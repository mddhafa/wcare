<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Models\ChatBotHistory;
use App\Models\ChatBotSession;
use App\Models\ChatBotMessage;

class ChatbotController extends Controller
{

    public function newSession()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['ok' => false], 401);
        }

        $session = ChatBotSession::create([
            'user_id' => $user->user_id,
            'title' => 'Obrolan Baru'
        ]);

        return response()->json([
            'ok' => true,
            'session_id' => $session->id
        ]);
    }

    public function sessions()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['ok' => false, 'sessions' => []], 401);
        }

        $sessions = ChatBotSession::where('user_id', $user->user_id)
            ->orderBy('updated_at', 'desc')
            ->get(['id', 'title', 'updated_at']);

        return response()->json([
            'ok' => true,
            'sessions' => $sessions
        ]);
    }

    public function messages($sessionId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['ok' => false, 'messages' => []], 401);
        }

        $session = ChatBotSession::where('id', $sessionId)
            ->where('user_id', $user->user_id)
            ->first();

        if (!$session) {
            return response()->json(['ok' => false, 'messages' => []], 404);
        }

        $messages = ChatBotMessage::where('chat_session_id', $session->id)
            ->orderBy('created_at', 'asc')
            ->get(['role', 'content']);

        return response()->json([
            'ok' => true,
            'messages' => $messages
        ]);
    }

    public function send(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'session_id' => 'required|integer',
            'message'    => 'required|string|max:20000',
        ]);

        $userId    = $user->user_id ?? $user->id;
        $sessionId = (int) $request->session_id;
        $message   = trim((string) $request->message);

        try {
            // Pastikan session milik user ini
            $session = ChatBotSession::where('id', $sessionId)
                ->where('user_id', $userId)
                ->first();

            if (!$session) {
                return response()->json(['ok' => false, 'error' => 'Session not found'], 404);
            }

            // Simpan pesan user
            ChatBotMessage::create([
                'chat_session_id' => $sessionId,
                'user_id' => $userId,
                'role' => 'user',
                'content' => $message,
            ]);

            // Update title jika masih default
            if ($session->title === 'Obrolan Baru') {
                $session->update(['title' => mb_substr($message, 0, 30)]);
            }

            // 1) Preset dulu
            $normalized = mb_strtolower($message);
            $presets = $this->presetReplies();
            if (isset($presets[$normalized])) {
                $reply = $presets[$normalized];
                $source = 'preset';

                ChatBotMessage::create([
                    'chat_session_id' => $sessionId,
                    'user_id' => $userId,
                    'role' => 'bot',
                    'content' => $reply,
                ]);

                return response()->json([
                    'ok' => true,
                    'response' => $reply,
                    'source' => $source,
                ], 200);
            }

            // 2) Panggil Gemini
            [$reply, $source] = $this->replyFromGeminiOrFallback($message);

            // Simpan balasan bot
            ChatBotMessage::create([
                'chat_session_id' => $sessionId,
                'user_id' => $userId,
                'role' => 'bot',
                'content' => $reply,
            ]);

            return response()->json([
                'ok' => true,
                'response' => $reply,
                'source' => $source,
            ], 200);

        } catch (\Throwable $e) {
            Log::error('chat/send error', [
                'message' => $e->getMessage(),
                'user_id' => $userId,
                'session_id' => $sessionId,
            ]);

            return response()->json([
                'ok' => false,
                'error' => 'Internal server error',
            ], 500);
        }
    }

    // =========================
    // GEMINI CALL + ERROR MAPPING
    // =========================
    private function replyFromGeminiOrFallback(string $message): array
    {
        $apiKey  = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $baseUrl = config('services.gemini.base_url', env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com'));
        $model   = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));

        if (empty($apiKey)) {
            return [
                "Maaf, layanan AI belum bisa digunakan karena konfigurasi server belum lengkap (API key belum di-set). 🙏",
                "config_error"
            ];
        }

        $endpoint = "{$baseUrl}/v1/models/{$model}:generateContent";

        $payload = [
            'contents' => [[
                'role' => 'user',
                'parts' => [['text' => $message]],
            ]],
            'generationConfig' => [
                'temperature' => 0.7,
                'candidateCount' => 1,
                'maxOutputTokens' => 512,
            ],
        ];

        try {
            $res = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type'   => 'application/json',
            ])->timeout(60)->post($endpoint, $payload);

            if (!$res->successful()) {
                $status = $res->status();
                $bodyJson = $res->json();
                $bodyText = $res->body();

                Log::error('Gemini upstream error', [
                    'status' => $status,
                    'body_json' => $bodyJson,
                    'body_text' => $bodyText,
                    'endpoint' => $endpoint,
                ]);

                // --- mapping error yang BENAR ---
                if ($status === 429) {
                    // rate limit / quota
                    $msg = $bodyJson['error']['message'] ?? null;
                    $retry = $bodyJson['error']['details'][2]['retryDelay'] ?? null;

                    $extra = "";
                    if ($retry) $extra = "\n\nCoba lagi dalam {$retry} ya.";

                    return [
                        "Maaf ya, layanan AI sedang penuh/kena limit sebentar 🙏{$extra}\n\n"
                        . "Sambil nunggu, kamu mau pilih?\n"
                        . "1) Curhat\n2) Motivasi\n3) Info konseling UMY\n\n"
                        . "Balas angka 1/2/3 ya.",
                        "rate_limited"
                    ];
                }

                if (in_array($status, [401, 403], true)) {
                    return [
                        "Maaf, akses ke layanan AI ditolak (API key/izin). 🙏\n"
                        . "Coba cek GEMINI_API_KEY, billing/plan, dan izin project di Google AI Studio.",
                        "auth_error"
                    ];
                }

                if ($status >= 500) {
                    return [
                        "Maaf ya, layanan AI sedang gangguan. 🙏\n"
                        . "Coba lagi beberapa menit lagi.\n\n"
                        . "Kalau kamu mau, kamu bisa tetap cerita di sini—aku akan respon sebisaku.",
                        "upstream_down"
                    ];
                }

                return [
                    "Maaf, permintaan belum bisa diproses (error {$status}). 🙏\n"
                    . "Coba kirim ulang pesanmu ya.",
                    "other_error"
                ];
            }

            $json = $res->json();
            $reply = $json['candidates'][0]['content']['parts'][0]['text']
                ?? "Maaf, aku belum bisa memproses itu sekarang.";

            return [$reply, "gemini"];

        } catch (\Throwable $e) {
            Log::error('Exception calling Gemini', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                "Maaf ya, aku lagi kesulitan menghubungi layanan AI 🙏\n"
                . "Tapi aku tetap di sini. Kamu mau cerita pelan-pelan tentang apa yang kamu rasakan?",
                "exception"
            ];
        }
    }

    // =========================
    // PRESET REPLIES
    // =========================
    private function presetReplies(): array
    {
        return [
            'aku cape banget hari ini aku mau curhat' =>
                "Aku dengerin ya. Mau cerita bagian paling beratnya apa?",
            'apakah ada nomor layanan konseling untuk kejiwaan khusus mahasiswa umy' =>
                "Untuk layanan konseling mahasiswa UMY, kamu bisa menghubungi Admin Stuwess di +62 858-9155-8548.",
            'saya butuh motivasi' =>
                "Kamu sudah bertahan sejauh ini, itu bukti kamu kuat. Mau cerita kamu sedang menghadapi apa?",
            '1' => "Oke, aku dengerin ya. Ceritain pelan-pelan, apa yang paling bikin kamu capek akhir-akhir ini?",
            '2' => "Kamu hebat karena masih bertahan sampai hari ini. Yuk, fokus ke 1 langkah kecil dulu. Hal kecil apa yang bisa kamu lakukan hari ini?",
            '3' => "Info konseling UMY: kamu bisa hubungi Admin Stuwess di +62 858-9155-8548.",
        ];
    }
}
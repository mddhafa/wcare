<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Models\ChatBotHistory;

class ChatbotController extends Controller
{
    public function generate(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['ok' => false, 'response' => 'Unauthorized'], 401);
        }

        $request->validate([
            'message' => 'required|string|max:20000'
        ]);

        $message = $request->input('message');

        //call preset replies first
        $normalized = mb_strtolower(trim($message));
        $presets = $this->presetReplies();

        if (isset($presets[$normalized])) {
            $reply = $presets[$normalized];

            ChatBotHistory::create([
                'user_id' => $userId,
                'message' => $message,
                'response' => $reply,
            ]);

            return response()->json([
                'ok' => true,
                'response' => $reply,
                'source' => 'preset'
            ], 200);
        }

        //call Gemini API
        $apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $baseUrl = config('services.gemini.base_url', env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com'));
        $model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-2.5-flash'));
        
        // Cek API Key
        if (empty($apiKey)) {
            Log::error('GEMINI_API_KEY missing in .env or config/services.php');
            return response()->json([
                'ok' => false,
                'error' => 'Server misconfiguration: GEMINI_API_KEY not set'
            ], 500);
        }

        // Endpoint yang benar
        $endpoint = "{$baseUrl}/v1/models/{$model}:generateContent";

        // Struktur payload yang disesuaikan
        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $message]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'candidateCount' => 1
            ]
        ];

        try {
            // Panggil API
            $res = Http::withHeaders([
                'x-goog-api-key' => $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($endpoint, $payload); // Panggilan HTTP

            // ... (Penanganan respons yang gagal - 502)
            if (!$res->successful()) {
                $status = $res->status();
                $body = $res->body();
                Log::error('Gemini upstream error', [
                    'status' => $status,
                    'body' => $body,
                    'endpoint' => $endpoint,
                ]);

                // ... (Parsing JSON dan pengembalian 502)
                $maybeJson = $res->json(); 
                
                return response()->json([
                    'ok' => false,
                    'error' => 'Upstream error from Gemini',
                    'status' => $status,
                    'body' => $maybeJson ?? $body
                ], 502);
            }

            $json = $res->json();

            $reply = null;
            if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
                 $reply = $json['candidates'][0]['content']['parts'][0]['text'];
            } else {
                $reply = 'Maaf, saya tidak dapat memproses permintaan Anda saat ini.';
            }

            ChatBotHistory::create([
                'user_id' => $userId,
                'message' => $message,
                'response' => $reply,
            ]);

            return response()->json([
                'ok' => true,
                'response' => $reply,
                'raw' => $json,
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'error' => 'Exception when calling Gemini API (Internal Server Error)',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function presetReplies(): array
    {
        return [
            'aku cape banget hari ini aku mau curhat' => "Aku dengerin ya. Mau cerita bagian paling beratnya apa? Kamu capek karena tugas, teman, keluarga, atau hal lain?",
            'apakah ada nomor layanan konseling untuk kejiwaan khusus mahasiswa umy' => "Untuk layanan konseling mahasiswa UMY, Kamu bisa menghubungi nomor Layanan Konseling +62 858-9155-8548 (Admin Stuwess) ",
            'saya butuh motivasi' => "Kamu sudah bertahan sejauh ini, itu bukti kamu kuat. Coba tulis 1 hal kecil yang bisa kamu selesaikan hari ini (misal 10 menit beresin tugas). Mau kamu lagi menghadapi apa sekarang?",
        ];
    }


    public function history()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['ok' => false, 'history' => []], 401);
        }

        $chats = ChatHistory::where('user_id', $userId)
            ->orderBy('created_at', 'asc')
            ->get(['id','message','response','created_at']);

        return response()->json(['ok' => true, 'history' => $chats]);
    }

     public function newChat()
    {
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['ok' => false, 'message' => 'Unauthorized'], 401);
        }

        ChatHistory::where('user_id', $userId)->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Obrolan baru dimulai'
        ], 200);
    }

}
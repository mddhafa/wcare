<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PsikologChatController extends Controller
{
    // 1. TAMPILKAN KORBAN YANG LAPORANNYA SUDAH DIPROSES
    public function index()
    {
        $psikologId = Auth::user()->user_id;

        $users = User::where('role_id', 3)
            ->whereHas('laporan', function ($q) {
                $q->whereIn('status', ['proses', 'selesai']);
            })
            ->get();

        return view('Psikolog.chat', compact('users'));
    }

    // 2. AMBIL CHAT DENGAN KORBAN
    public function showJson(User $user)
    {
        $psikologId = Auth::user()->user_id;

        $messages = Chat::where(function ($q) use ($psikologId, $user) {
            $q->where('sender_id', $psikologId)
              ->where('receiver_id', $user->user_id);
        })->orWhere(function ($q) use ($psikologId, $user) {
            $q->where('sender_id', $user->user_id)
              ->where('receiver_id', $psikologId);
        })
        ->orderBy('created_at')
        ->get();
 
        return response()->json([
            'messages' => $messages,
            'psikolog_id' => $psikologId
        ]);
    }

    // 3. PSIKOLOG MEMULAI CHAT (CHAT PERTAMA)
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string'
        ]);

        // pastikan korban punya laporan yang sudah diproses
        $allowed = Laporan::where('user_id', $request->receiver_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->exists();

        if (!$allowed) {
            return response()->json([
                'error' => 'Laporan belum diproses admin'
            ], 403);
        }

        $chat = Chat::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return response()->json($chat);
    }
}

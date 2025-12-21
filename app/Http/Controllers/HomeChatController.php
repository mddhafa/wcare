<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeChatController extends Controller
{
    public function index()
    {
        $psikolog = User::where('role_id', 2)->get();
        return view('korban.homechat', compact('psikolog'));
    }

    // Method untuk korban mengirim chat
    public function sendChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string'
        ]);

        $korbanId = Auth::user()->user_id;
        $psikologId = $request->receiver_id;

        // Cek apakah psikolog sudah memulai chat
        $psikologStarted = Chat::where('sender_id', $psikologId)
                                ->where('receiver_id', $korbanId)
                                ->exists();

        if (!$psikologStarted) {
            return response()->json([
                'error' => 'Belum bisa mengirim pesan. Tunggu psikolog memulai chat terlebih dahulu.'
            ], 403);
        }

        $chat = Chat::create([
            'sender_id' => $korbanId,
            'receiver_id' => $psikologId,
            'message' => $request->message
        ]);

        return response()->json($chat);
    }
}

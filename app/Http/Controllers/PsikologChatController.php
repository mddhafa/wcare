<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class PsikologChatController extends Controller
{
    // Tampilkan daftar pasien yang pernah chat
    public function index()
    {
        $psikologId = Auth::user()->user_id; // ini ID psikolog login

        $users = User::where('role_id', 3)
            ->where(function ($q) use ($psikologId) {
                $q->whereHas('sentChats', fn($qq) => $qq->where('receiver_id', $psikologId))
                    ->orWhereHas('receivedChats', fn($qq) => $qq->where('sender_id', $psikologId));
            })
            ->get();

        return view('Psikolog.chat', compact('users', 'psikologId'));
    }

    // Ambil chat untuk satu pasien
    public function showJson(User $user)
    {
        $psikologId = Auth::user()->user_id;

        $messages = Chat::where(function ($q) use ($psikologId, $user) {
            $q->where('sender_id', $psikologId)->where('receiver_id', $user->user_id)
                ->orWhere(function ($qq) use ($psikologId, $user) {
                    $qq->where('sender_id', $user->user_id)->where('receiver_id', $psikologId);
                });
        })->orderBy('created_at')->get();

        return response()->json([
            'messages' => $messages,
            'psikolog_id' => $psikologId
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required'
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return response()->json($chat);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    public function index($id_psikolog)
    {
        $psikolog = User::findOrFail($id_psikolog);

        $userId = Auth::id();

        $messages = Chat::where(function ($q) use ($userId, $id_psikolog) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', $id_psikolog);
        })
            ->orWhere(function ($q) use ($userId, $id_psikolog) {
                $q->where('sender_id', $id_psikolog)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('korban.chat', compact('psikolog', 'messages'));
    }

    // Mengirim pesan
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'message' => 'required|string'
        ]);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        return back();
    }

    public function refresh($id_psikolog)
    {
        $userId = Auth::id();

        $messages = Chat::where(function ($q) use ($userId, $id_psikolog) {
            $q->where('sender_id', $userId)
                ->where('receiver_id', $id_psikolog);
        })
            ->orWhere(function ($q) use ($userId, $id_psikolog) {
                $q->where('sender_id', $id_psikolog)
                    ->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages
        ]);
    }
}
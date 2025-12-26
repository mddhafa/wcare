<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\MessageRead;

class ChatController extends Controller
{
    public function homechat()
    {
        $userId = Auth::id();

        $chatPartnerIds = Chat::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->map(function ($chat) use ($userId) {
                return $chat->sender_id == $userId ? $chat->receiver_id : $chat->sender_id;
            })
            ->unique();

        $psikolog = User::whereIn('user_id', $chatPartnerIds)
            ->where('role_id', 2)
            ->get();

        $psikologList = $psikolog->map(function ($p) {
            return [
                'id' => $p->user_id,
                'name' => $p->name
            ];
        })->values();

        return view('Korban.homechat', compact('psikolog', 'psikologList'));
    }

    public function index($id_psikolog)
    {
        $korbanId = Auth::id();
        $psikolog = User::findOrFail($id_psikolog);

        $updated = Chat::where('sender_id', $id_psikolog)
            ->where('receiver_id', $korbanId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        if ($updated > 0) {
            broadcast(new MessageRead($id_psikolog, $korbanId));
        }

        $messages = Chat::where(function ($q) use ($korbanId, $id_psikolog) {
            $q->where('sender_id', $korbanId)->where('receiver_id', $id_psikolog);
        })->orWhere(function ($q) use ($korbanId, $id_psikolog) {
            $q->where('sender_id', $id_psikolog)->where('receiver_id', $korbanId);
        })
            ->orderBy('created_at', 'asc')
            ->get();

        return view('korban.chat', compact('psikolog', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string'
        ]);

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => 0
        ]);

        broadcast(new MessageSent($chat))->toOthers();

        return response()->json($chat);
    }

    public function checkNewMessage()
    {
        $exists = Chat::where('receiver_id', Auth::id())
            ->where('is_read', 0)
            ->exists();

        return response()->json(['new_message' => $exists]);
    }

    public function refresh($id)
    {
        $korbanId = Auth::id();

        $messages = Chat::where(function ($q) use ($korbanId, $id) {
            $q->where('sender_id', $korbanId)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($korbanId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $korbanId);
        })->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages]);
    }

    public function markAsRead(Request $request)
    {
        $korbanId = Auth::id();
        $psikologId = $request->sender_id;

        Chat::where('sender_id', $psikologId)
            ->where('receiver_id', $korbanId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        broadcast(new MessageRead($psikologId, $korbanId));

        return response()->json(['status' => 'success']);
    }
}

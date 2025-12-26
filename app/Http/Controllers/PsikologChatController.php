<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Chat;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Events\MessageRead;

class PsikologChatController extends Controller
{
    public function index()
    {
        $psikologId = Auth::user()->user_id;

        $users = User::where('role_id', 3)
            ->whereHas('laporan', function ($q) {
                $q->whereIn('status', ['proses', 'selesai']);
            })
            ->get()
            ->map(function ($user) use ($psikologId) {
                $lastChat = Chat::where(function ($q) use ($psikologId, $user) {
                    $q->where('sender_id', $psikologId)->where('receiver_id', $user->user_id);
                })->orWhere(function ($q) use ($psikologId, $user) {
                    $q->where('sender_id', $user->user_id)->where('receiver_id', $psikologId);
                })->latest('created_at')->first();

                $unreadCount = Chat::where('sender_id', $user->user_id)
                    ->where('receiver_id', $psikologId)
                    ->where('is_read', 0)
                    ->count();

                $user->last_message = $lastChat;
                $user->last_message_time = $lastChat ? $lastChat->created_at : null;
                $user->unread_count = $unreadCount;

                return $user;
            })
            ->sortByDesc('last_message_time')
            ->values();

        return view('Psikolog.chat', compact('users'));
    }

    public function showJson(User $user)
    {
        $psikologId = Auth::user()->user_id;

        $unreadMessages = Chat::where('sender_id', $user->user_id)
            ->where('receiver_id', $psikologId)
            ->where('is_read', 0)
            ->exists();

        Chat::where('sender_id', $user->user_id)
            ->where('receiver_id', $psikologId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        if ($unreadMessages) {
            broadcast(new MessageRead($user->user_id, $psikologId));
        }

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

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message' => 'required|string'
        ]);

        $allowed = Laporan::where('user_id', $request->receiver_id)
            ->whereIn('status', ['proses', 'selesai'])
            ->exists();

        if (!$allowed) {
            return response()->json(['error' => 'Laporan belum diproses'], 403);
        }

        $chat = Chat::create([
            'sender_id' => Auth::user()->user_id,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => 0
        ]);

        broadcast(new MessageSent($chat))->toOthers();

        return response()->json($chat);
    }

    public function markAsRead(Request $request)
    {
        $psikologId = Auth::user()->user_id;
        $senderId = $request->sender_id;

        Chat::where('sender_id', $senderId)
            ->where('receiver_id', $psikologId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        broadcast(new MessageRead($senderId, $psikologId));

        return response()->json(['status' => 'success']);
    }
}

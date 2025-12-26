<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver_id;
    public $sender_id;

    public function __construct($receiver_id, $sender_id)
    {
        $this->receiver_id = $receiver_id;
        $this->sender_id = $sender_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.user.' . $this->receiver_id);
    }

    public function broadcastAs()
    {
        return 'message.read';
    }
}
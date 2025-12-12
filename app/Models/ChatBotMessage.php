<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatBotMessage extends Model
{
    use HasFactory;

    protected $table = 'chatbot_messages';
    protected $fillable = ['chat_session_id','user_id' , 'role', 'content'];

    public function session()
    {
        return $this->belongsTo(ChatSession::class, 'chat_session_id');
    }
}

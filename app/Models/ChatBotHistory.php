<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ChatBotHistory extends Model
{
    use HasFactory;

    protected $table = 'chatbot_histories';

    protected $fillable = [
        'user_id',
        'message',
        'response'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

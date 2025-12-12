<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatBotSession extends Model
{
  use HasFactory;

  protected $table = 'chatbot_sessions';
  protected $fillable = ['user_id', 'title'];

  public function messages()
  {
    return $this->hasMany(ChatMessage::class);
  }
}
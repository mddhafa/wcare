<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('chat.user.{id}', function ($user, $id) {
    Log::info("Cek Auth User: {$user->user_id} vs Channel ID: {$id}");
    
    return (int) $user->user_id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.user.{id}', function ($user, $id) {
    return (int) $user->user_id === (int) $id;
});

Broadcast::channel('presence-chat', function ($user) {
    return ['id' => $user->user_id, 'name' => $user->name];
});
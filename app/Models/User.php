<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

// Import Model Relasi
use App\Models\Admin;
use App\Models\Psikolog;
use App\Models\Korban;
use App\Models\Emosi;
use App\Models\Role;
use App\Models\Chat;
use App\Models\Laporan;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'active_status',
        'current_emosi_id',
        'avatar',
        'dark_mode',
        'messenger_color'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'user_id', 'user_id');
    }
    public function laporan()
{
    return $this->hasMany(Laporan::class, 'user_id', 'user_id');
}


    public function psikolog()
    {
        return $this->hasOne(Psikolog::class, 'user_id', 'user_id');
    }

    public function korban()
    {
        return $this->hasOne(Korban::class, 'user_id', 'user_id');
    }

    public function emosiSekarang()
    {
        return $this->belongsTo(Emosi::class, 'current_emosi_id', 'id_emosi');
    }

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'sender_id', 'user_id');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'receiver_id', 'user_id');
    }
}

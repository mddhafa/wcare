<?php

namespace App\Models;

<<<<<<< HEAD
=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable 
{
<<<<<<< HEAD
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

=======
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'users';
    protected $primaryKey = 'user_id';
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

<<<<<<< HEAD
=======
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
=======
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
<<<<<<< HEAD
=======
            'password' => 'hashed',
>>>>>>> 9f19b2d005664097d4bde2ffd86e7f22eea44af3
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function psikolog()
    {
        return $this->hasOne(Psikolog::class);
    }

    public function korban()
    {
        return $this->hasOne(Korban::class);
    }
}

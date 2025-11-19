<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    protected $fillable = ['user_id', 'name', 'email', 'password', 'umur', 'jenis_kelamin' ];
    protected $table = 'korban';

    public function laporan ()
    {
        return $this->hasMany(Laporan::class);
    }
}

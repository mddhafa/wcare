<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    protected $fillable = ['name', 'email', 'password', 'jadwal_tersedia' ];
    protected $table = 'psikolog';

    public function laporan ()
    {
        return $this->hasMany(Laporan::class);
    }
}

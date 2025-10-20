<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['name', 'email', 'password'];
    protected $table = 'admin';

    public function laporan ()
    {
        return $this->hasMany(Laporan::class);
    }

}

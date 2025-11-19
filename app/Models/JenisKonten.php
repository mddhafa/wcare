<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKonten extends Model
{
    protected $table = 'jenis_konten';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_emosi',
    ];

    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi');
    }

    public function selfHealing()
    {
        return $this->hasMany(SelfHealing::class, 'jenis_konten');
    }
}
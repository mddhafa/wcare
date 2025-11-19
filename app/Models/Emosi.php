<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emosi extends Model
{
    protected $table = 'emosi';
    protected $primaryKey = 'id_emosi';
    protected $fillable = [
        'jenis_emosi', 
    ];

    public function jenisKonten()
    {
        return $this->hasMany(JenisKonten::class, 'id_emosi');
    }
}

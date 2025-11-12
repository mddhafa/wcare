<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emosi extends Model
{
    protected $table = 'emosi';
    protected $primaryKey = 'id_emosi';
    protected $fillable = [
        'id_korban',
        'skor',
        'jenis_emosi',
    ];

    public function korban()
    {
        return $this->belongsTo(Korban::class, 'id_korban');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelfHealing extends Model
{
    use HasFactory;

    protected $table = 'selfhealing';

    protected $primaryKey = 'id_selfhealing';

    // Kolom yang boleh diisi
    protected $fillable = [
        'id_emosi',
        'jenis_konten',
        'judul',
        'deskripsi',
        'link_konten',
        'gambar',
        'audio'
    ];

    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi', 'id_emosi');
    }
}

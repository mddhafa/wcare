<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelfHealing extends Model
{
    protected $table = 'selfhealing';
    protected $primaryKey = 'id_selfhealing';
    protected $fillable = [
        // 'id_admin',
        'jenis_konten',
        'judul',
        'link_konten',
        'deskripsi',
        'gambar'
    ];

}

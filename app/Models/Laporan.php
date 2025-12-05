<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'user_id',
        'lokasi',
        'jenis',
        'kronologi',
        'status',
        'tanggal',
    ];

    public function korban()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

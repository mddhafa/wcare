<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Psikolog;

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
      public function psikolog(): BelongsTo
    {
        return $this->belongsTo(Psikolog::class, 'assigned_psikolog_id', 'id_psikolog');
    }
}

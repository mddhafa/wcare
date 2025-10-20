<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = ['lokasi', 'jenis', 'kronologi', 'status', 'tanggal'];
    protected $table = 'laporan';

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}

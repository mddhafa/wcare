<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->validateTanggal();
        });
    }

    public function validateTanggal()
    {
        if ($this->tanggal) {
            $tanggalKejadian = Carbon::parse($this->tanggal);
            $limaTahunLalu = Carbon::now()->subYears(5);
            $hariIni = Carbon::now();
            
            $tanggalKejadian->setTime(0, 0, 0);
            $limaTahunLalu->setTime(0, 0, 0);
            $hariIni->setTime(0, 0, 0);
            
            if ($tanggalKejadian->lt($limaTahunLalu)) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Tanggal kejadian tidak boleh lebih dari 5 tahun yang lalu.'
                ]);
            }
            
            if ($tanggalKejadian->gt($hariIni)) {
                throw ValidationException::withMessages([
                    'tanggal' => 'Tanggal kejadian tidak boleh lebih dari hari ini.'
                ]);
            }
        }
    }
}
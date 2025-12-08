<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korban extends Model
{
    use HasFactory;

    protected $table = 'korban';
    protected $primaryKey = 'id_korban';

    protected $fillable = [
        'user_id',
        'umur',
        'jenis_kelamin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}

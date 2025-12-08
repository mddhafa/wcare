<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmosiSeeder extends Seeder
{
    public function run(): void
    {
        // PENTING: Karena di migration kamu tulis $table->id('id_emosi');
        // Maka disini kuncinya HARUS 'id_emosi', bukan 'id'.

        $data = [
            ['id_emosi' => 1, 'jenis_emosi' => 'Senang', 'created_at' => now(), 'updated_at' => now()],
            ['id_emosi' => 2, 'jenis_emosi' => 'Marah', 'created_at' => now(), 'updated_at' => now()],
            ['id_emosi' => 3, 'jenis_emosi' => 'Sedih', 'created_at' => now(), 'updated_at' => now()],
            ['id_emosi' => 4, 'jenis_emosi' => 'Takut', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('emosi')->insertOrIgnore($data);
    }
}

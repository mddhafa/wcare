<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Psikolog;
use App\Models\Korban;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT DATA ROLES
        DB::table('roles')->insertOrIgnore([
            ['id' => 1, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'psikolog', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'korban', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==========================================
        // 2. ADMIN
        // ==========================================
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'email_verified_at' => now(),
            'active_status' => 0,
        ]);

        // ==========================================
        // 3. PSIKOLOG
        // ==========================================

        $psikologs = [
            ['name' => 'Dr. Siti Nurhaliza, M.Psi', 'email' => 'siti@psikolog.com'],
            ['name' => 'Ahmad Fauzan, M.Psi', 'email' => 'fauzan@psikolog.com'],
            ['name' => 'Dr. Rina Amalia, Sp.KJ', 'email' => 'rina@psikolog.com'],
            ['name' => 'Budi Santoso, S.Psi, M.Si', 'email' => 'budi@psikolog.com'],
        ];

        foreach ($psikologs as $p) {
            // A. Buat User (Data Login & Nama)
            $user = User::create([
                'name' => $p['name'],
                'email' => $p['email'],
                'password' => Hash::make('password'),
                'role_id' => 2,
                'email_verified_at' => now(),
                'active_status' => 0,
            ]);

            // B. Buat Detail Psikolog (Hanya data tambahan)
            Psikolog::create([
                'user_id' => $user->user_id, // Terhubung otomatis
                'jadwal_tersedia' => now()->addDay(),
            ]);
        }

        // ==========================================
        // 4. KORBAN / MAHASISWA
        // ==========================================

        $korbans = [
            ['name' => 'User Pertama (Anonim)', 'email' => 'user1@gmail.com', 'jk' => 'Laki-laki', 'umur' => 21],
            ['name' => 'Rizky Pratama', 'email' => 'rizky@gmail.com', 'jk' => 'Laki-laki', 'umur' => 20],
            ['name' => 'Maya Putri Sari', 'email' => 'maya@gmail.com', 'jk' => 'Perempuan', 'umur' => 19],
            ['name' => 'Dimas Anggara', 'email' => 'dimas@gmail.com', 'jk' => 'Laki-laki', 'umur' => 22],
            ['name' => 'Citra Kirana', 'email' => 'citra@gmail.com', 'jk' => 'Perempuan', 'umur' => 20],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@gmail.com', 'jk' => 'Laki-laki', 'umur' => 23],
        ];

        foreach ($korbans as $k) {
            // A. Buat User
            $user = User::create([
                'name' => $k['name'],
                'email' => $k['email'],
                'password' => Hash::make('password'),
                'role_id' => 3,
                'email_verified_at' => now(),
                'active_status' => 0,
            ]);

            // B. Buat Detail Korban
            Korban::create([
                'user_id' => $user->user_id, // Terhubung otomatis
                'umur' => $k['umur'],
                'jenis_kelamin' => $k['jk'],
            ]);
        }

        // ==========================================
        // 5. SEEDER TAMBAHAN
        // ==========================================
        $this->call([
            EmosiSeeder::class,
        ]);
    }
}

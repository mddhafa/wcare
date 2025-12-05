<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'psikolog', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'korban', 'created_at' => now(), 'updated_at' => now()],
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // ID 1 adalah Admin
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Dr. Siti Nurhaliza, M.Psi',
            'email' => 'siti@psikolog.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmad Fauzan, M.Psi',
            'email' => 'fauzan@psikolog.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'user pertama',
            'email' => 'user1@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'user kedua',
            'email' => 'user2@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'user ketiga',
            'email' => 'user3@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3,
            'email_verified_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin / Waka (role_id = 1)
        User::create([
            'name' => 'Admin Waka',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => 1,
        ]);

        // 2. Akun PIC Ruangan (role_id = 2)
        User::create([
            'name' => 'PIC Ruang Lab',
            'email' => 'pic@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => 2,
        ]);

        // 3. Akun Guru / Organisasi (role_id = 3)
        User::create([
            'name' => 'Budi Santoso (Guru)',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('password123'),
            'role_id' => 3,
        ]);
    }
}
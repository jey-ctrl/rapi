<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Tabel Roles
        DB::table('roles')->insert([
            ['id' => 1, 'roles_name' => 'Admin / Waka', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'roles_name' => 'PIC Ruang', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'roles_name' => 'Guru / Organisasi', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed User Admin (Waka)
        User::create([
            'fullname'     => 'Waka Sarpras (Admin)',
            'username'     => 'waka',
            'email'        => 'admin@sekolah.sch.id',
            'phone_number' => '081234567890',
            'password'     => Hash::make('password123'),
            'role_id'      => 1,
        ]);

        // 3. Seed User PIC
        User::create([
            'fullname'     => 'PIC Laboratorium Komputer',
            'username'     => 'pic',
            'email'        => 'pic@sekolah.sch.id',
            'phone_number' => '081234567891',
            'password'     => Hash::make('password123'),
            'role_id'      => 2,
        ]);

        // 4. Seed User Guru
        User::create([
            'fullname'     => 'Guru Pembina / Pengampu',
            'username'     => 'guru',
            'email'        => 'guru@sekolah.sch.id',
            'phone_number' => '081234567892',
            'password'     => Hash::make('password123'),
            'role_id'      => 3,
        ]);
    }
}
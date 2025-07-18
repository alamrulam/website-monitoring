<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- Jangan lupa import
use Illuminate\Support\Facades\Hash; // <-- Jangan lupa import

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mencari user dengan email admin, jika tidak ada maka akan dibuat baru.
        // Ini mencegah error jika seeder dijalankan lebih dari satu kali.
        User::firstOrCreate(
            ['email' => 'admin@proyek.com'], // Kondisi pencarian
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
                'role' => 'admin',
            ]
        );
    }
}

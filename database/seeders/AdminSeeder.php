<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // cek kalau sudah ada
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // ganti sesuai kebutuhan
                'role' => 'admin'
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // password bcrypt
                'role' => 'admin',
            ]
        );

        // Buat akun Pelanggan
        User::updateOrCreate(
            ['email' => 'karyawan@gmail.com'],
            [
                'name' => 'karyawan',
                'password' => Hash::make('karyawan123'), // password bcrypt
                'role' => 'karyawan',
            ]
        );

        // Buat akun Owner
        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'owner',
                'password' => Hash::make('owner123'), // password bcrypt
                'role' => 'owner',
            ]
        );
    }
}

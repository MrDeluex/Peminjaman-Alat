<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            // ADMIN
            [
                'username' => 'admin1',
                'role' => 'admin',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PETUGAS
            [
                'username' => 'petugas1',
                'role' => 'petugas',
                'email' => 'petugas@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // PEMINJAM
            [
                'username' => 'user1',
                'role' => 'peminjam',
                'email' => 'user@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // tambahan biar realistis
            [
                'username' => 'user2',
                'role' => 'peminjam',
                'email' => 'user2@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
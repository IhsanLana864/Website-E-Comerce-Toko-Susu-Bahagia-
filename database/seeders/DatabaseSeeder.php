<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Administrator',
            'email' => 'foureignteam@gmail.com',
            'password' => Hash::make('admin123'), // Ganti 'password' sesuai keinginan
            'no_telepon' => '081234567890', // Ganti nomor telepon sesuai keinginan
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
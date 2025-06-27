<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Tasneem Admin',
            'email' => 'admin@training.com',
            'password' => Hash::make('admin123'),
            'level' => 1, // Admin
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        // Create advisor users
        User::create([
            'name' => 'Osama Advisor',
            'email' => 'osama@training.com',
            'password' => Hash::make('advisor123'),
            'level' => 2, // Advisor
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ahmed Advisor',
            'email' => 'ahmed.advisor@training.com',
            'password' => Hash::make('advisor123'),
            'level' => 2, // Advisor
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        // Create trainee users
        User::create([
            'name' => 'Shatha Trainee',
            'email' => 'shatha@training.com',
            'password' => Hash::make('trainee123'),
            'level' => 3, // Trainee
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Fatima Trainee',
            'email' => 'fatima@training.com',
            'password' => Hash::make('trainee123'),
            'level' => 3, // Trainee
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Mohammed Trainee',
            'email' => 'mohammed@training.com',
            'password' => Hash::make('trainee123'),
            'level' => 3, // Trainee
            'unique_id' => Str::uuid(),
            'email_verified_at' => now(),
        ]);
    }
} 
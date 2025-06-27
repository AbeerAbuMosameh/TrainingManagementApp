<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trainee;
use Illuminate\Support\Facades\Hash;

class TraineeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Trainee::create([
            'first_name' => 'Shatha',
            'last_name' => 'ISA',
            'email' => 'shatha@email.com',
            'phone' => '123456789',
            'education' => 'IT',
            'address' => 'Gaza',
            'password' => Hash::make('secret123'),
            'gpa' => '3.8',
            'city' => 'Gaza City',
            'language' => 'English',
            'is_approved' => true,
        ]);

        Trainee::create([
            'first_name' => 'Ahmed',
            'last_name' => 'Mohammed',
            'email' => 'ahmed@email.com',
            'phone' => '987654321',
            'education' => 'Computer Science',
            'address' => 'Khan Younis',
            'password' => Hash::make('password123'),
            'gpa' => '3.5',
            'city' => 'Khan Younis',
            'language' => 'Arabic',
            'is_approved' => false,
        ]);

        Trainee::create([
            'first_name' => 'Fatima',
            'last_name' => 'Ali',
            'email' => 'fatima@email.com',
            'phone' => '555666777',
            'education' => 'Software Engineering',
            'address' => 'Rafah',
            'password' => Hash::make('secure456'),
            'gpa' => '3.9',
            'city' => 'Rafah',
            'language' => 'English',
            'is_approved' => true,
        ]);
    }
} 
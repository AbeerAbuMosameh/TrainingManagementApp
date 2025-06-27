<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Full Stack Web Development',
                'type' => 'paid',
                'price' => 700,
                'hours' => '120',
                'start_date' => '2025-09-01',
                'end_date' => '2025-12-01',
                'field_id' => 1,
                'advisor_id' => 3,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'description' => 'Learn modern web development with React, Node.js, and Laravel',
                'number' => 20,
            ],
            [
                'name' => 'Data Analysis with Python',
                'type' => 'free',
                'hours' => '40',
                'start_date' => '2025-09-01',
                'end_date' => '2025-09-30',
                'field_id' => 3,
                'advisor_id' => 4,
                'duration' => 'weeks',
                'level' => 'intermediate',
                'language' => 'English',
                'description' => 'Analyze datasets using pandas and matplotlib',
                'number' => 15,
            ],
            [
                'name' => 'Mobile App Development',
                'type' => 'paid',
                'price' => 500,
                'hours' => '80',
                'start_date' => '2025-07-01',
                'end_date' => '2025-08-01',
                'field_id' => 2,
                'advisor_id' => 5,
                'duration' => 'weeks',
                'level' => 'beginner',
                'language' => 'English',
                'description' => 'Build mobile apps with React Native and Flutter',
                'number' => 25,
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }
    }
} 
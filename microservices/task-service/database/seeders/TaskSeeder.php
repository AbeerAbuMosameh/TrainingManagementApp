<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::create([
            'program_id' => 1,
            'advisor_id' => 1,
            'start_date' => '2025-07-10',
            'end_date' => '2025-07-15',
            'mark' => 50,
            'description' => 'Create a responsive portfolio page using HTML, CSS, and JavaScript.',
            'related_file' => null,
        ]);

        Task::create([
            'program_id' => 1,
            'advisor_id' => 1,
            'start_date' => '2025-07-20',
            'end_date' => '2025-07-25',
            'mark' => 100,
            'description' => 'Build a RESTful API using Laravel with authentication and CRUD operations.',
            'related_file' => [
                'api_documentation.pdf',
                'database_schema.sql'
            ],
        ]);

        Task::create([
            'program_id' => 2,
            'advisor_id' => 2,
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-10',
            'mark' => 75,
            'description' => 'Analyze a dataset using Python pandas and create visualizations with matplotlib.',
            'related_file' => [
                'sample_dataset.csv',
                'requirements.txt'
            ],
        ]);
    }
} 
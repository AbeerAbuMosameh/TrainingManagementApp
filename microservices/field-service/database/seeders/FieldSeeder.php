<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Field;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Web Development',
                'description' => 'Full-stack web development including frontend and backend technologies',
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Development',
                'description' => 'iOS and Android mobile application development',
                'is_active' => true,
            ],
            [
                'name' => 'Data Science',
                'description' => 'Data analysis, machine learning, and artificial intelligence',
                'is_active' => true,
            ],
            [
                'name' => 'Cybersecurity',
                'description' => 'Network security, ethical hacking, and security protocols',
                'is_active' => true,
            ],
            [
                'name' => 'Cloud Computing',
                'description' => 'AWS, Azure, Google Cloud, and cloud infrastructure management',
                'is_active' => true,
            ],
            [
                'name' => 'DevOps',
                'description' => 'CI/CD, containerization, and infrastructure automation',
                'is_active' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'User interface and user experience design principles',
                'is_active' => true,
            ],
            [
                'name' => 'Database Administration',
                'description' => 'Database design, optimization, and management',
                'is_active' => true,
            ],
        ];

        foreach ($fields as $fieldData) {
            Field::create($fieldData);
        }
    }
}

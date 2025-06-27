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
            ['name' => 'Web Development'],
            ['name' => 'Mobile Development'],
            ['name' => 'Data Science'],
            ['name' => 'Artificial Intelligence'],
            ['name' => 'Cybersecurity'],
            ['name' => 'Cloud Computing'],
            ['name' => 'DevOps'],
            ['name' => 'UI/UX Design'],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }
    }
} 
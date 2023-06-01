<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            AdminPermissionsSeeder::class,
            AdminSeeder::class,
           AdvisorPermissionsSeeder::class,
           TraineePermissionsSeeder::class,
            FieldSeeder::class,
           PaymentSeeder::class
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Advisor;
use App\Models\Trainee;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            FieldSeeder::class,
            PaymentSeeder::class,
            AdminPermissionsSeeder::class,
            AdminSeeder::class,
           AdvisorPermissionsSeeder::class,
           AdvisorSeeder::class,
           TraineePermissionsSeeder::class,
            TraineeSeeder::class,

        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class TraineePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home
            ['name' => 't-home'],

            //Trainees
            ['name' => 't-program-list'],
            ['name' => 't-program-join'],


            ['name' => 't-pay-list'],
            ['name' => 't-pay-create'],
            ['name' => 't-pay-show'],
            ['name' => 't-pay-edit'],
            ['name' => 't-pay-delete'],

            //meeting
            ['name' => 't-meeting-create'],
            ['name' => 't-meeting-edit'],
            ['name' => 't-meeting-delete'],
            ['name' => 't-meeting-list'],
            ['name' => 't-meeting-show'],


            //Profile
            ['name' => 't-profile-edit'],
            ['name' => 't-profile-create'],
            ['name' => 't-profile-show'],
            ['name' => 't-profile-delete'],
            ['name' => 't-profile-list'],

            ['name' => 't-password-list'],
            ['name' => 't-password-edit'],
            ['name' => 't-password-show'],
            ['name' => 't-password-delete'],
            ['name' => 't-password-create'],

            ['name' => 't-attendance-list'],
            ['name' => 't-attendance-create'],
            ['name' => 't-attendance-show'],
            ['name' => 't-attendance-edit'],
            ['name' => 't-attendance-delete'],



        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 3]);
        }
    }
}

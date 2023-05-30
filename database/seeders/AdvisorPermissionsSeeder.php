<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdvisorPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home
            ['name' => 'a-home'],

            //Trainees
            ['name' => 'a-trainee-list'],
            ['name' => 'a-trainee-edit'],
            ['name' => 'a-trainee-delete'],
            ['name' => 'a-trainee-show'],
            ['name' => 'a-trainee-create'],

            //meeting
            ['name' => 'a-meeting-accept'],
            ['name' => 'a-meeting-list'],
            ['name' => 'a-meeting-create'],
            ['name' => 'a-meeting-show'],
            ['name' => 'a-meeting-edit'],

            //Programs
            ['name' => 'a-task-list'],
            ['name' => 'a-task-create'],
            ['name' => 'a-task-edit'],
            ['name' => 'a-task-delete'],
            ['name' => 'a-task-mark'],
            ['name' => 'a-task-show'],

            //Profile
            ['name' => 'a-profile-edit'],
            ['name' => 'a-profile-show'],
            ['name' => 'a-profile-create'],
            ['name' => 'a-profile-delete'],
            ['name' => 'a-profile-list'],

            ['name' => 'a-password-list'],
            ['name' => 'a-password-edit'],
            ['name' => 'a-password-show'],
            ['name' => 'a-password-create'],
            ['name' => 'a-password-delete'],




        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 2]);
        }
    }
}

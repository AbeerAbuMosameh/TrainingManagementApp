<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
            ['name' => 'advisor-trainee-list'],
            ['name' => 'advisor-trainee-edit'],
            ['name' => 'advisor-trainee-delete'],
            ['name' => 'advisor-trainee-show'],
            ['name' => 'advisor-trainee-create'],

            //program
            ['name' => 'advisor-program-list'],
            ['name' => 'advisor-program-show'],
            ['name' => 'advisor-program-trainees'],
            ['name' => 'advisor-program-trainees-list'],

            //meeting
            ['name' => 'advisor-meeting-accept'],
            ['name' => 'advisor-meeting-list'],
            ['name' => 'advisor-meeting-create'],
            ['name' => 'advisor-meeting-show'],
            ['name' => 'advisor-meeting-edit'],

            //Programs
            ['name' => 'advisor-task-list'],
            ['name' => 'advisor-task-create'],
            ['name' => 'advisor-task-edit'],
            ['name' => 'advisor-task-delete'],
            ['name' => 'advisor-task-mark'],
            ['name' => 'advisor-task-show'],
            ['name' => 'advisor-task-solution'],

            //Profile
            ['name' => 'advisor-profile-edit'],
            ['name' => 'advisor-profile-show'],
            ['name' => 'advisor-profile-list'],

            ['name' => 'advisor-password-list'],
            ['name' => 'advisor-password-edit'],
            ['name' => 'advisor-password-show'],




        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 2]);
        }



    }
}

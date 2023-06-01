<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TraineePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home
            ['name' => 'trainee-home'],

            //Trainees
            ['name' => 'trainee-training-program-accepted'],
            ['name' => 'trainee-training-program-join'],
            ['name' => 'trainee-training-program-all'],
            ['name' => 'trainee-meeting-list'],


            ['name' => 'trainee-pay-list'],
            ['name' => 'trainee-pay-create'],
            ['name' => 'trainee-pay-show'],
            ['name' => 'trainee-pay-edit'],
            ['name' => 'trainee-pay-delete'],

            //meeting
            ['name' => 'trainee-meeting-create'],
            ['name' => 'trainee-meeting-edit'],
            ['name' => 'trainee-meeting-delete'],
            ['name' => 'trainee-meeting-show'],

            //meeting
            ['name' => 'trainee-task-list'],
            ['name' => 'trainee-task-create'],
            ['name' => 'trainee-task-edit'],
            ['name' => 'trainee-task-delete'],
            ['name' => 'trainee-task-show'],


            ['name' => 'trainee-attendance-list'],
            ['name' => 'trainee-attendance-create'],
            ['name' => 'trainee-attendance-show'],
            ['name' => 'trainee-attendance-edit'],
            ['name' => 'trainee-attendance-delete'],


            //Profile
            ['name' => 'trainee-profile-edit'],
            ['name' => 'trainee-profile-show'],
            ['name' => 'trainee-profile-list'],

            ['name' => 'trainee-password-list'],
            ['name' => 'trainee-password-edit'],
            ['name' => 'trainee-password-show'],


        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 3]);
        }


        $role = Role::create(['name' => 'trainee', 'level' => 3]);

        $permissions = Permission::where(['level' => 3])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);
    }
}

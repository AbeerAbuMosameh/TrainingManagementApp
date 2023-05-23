<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Home
            ['name' => 'home'],

            //Roles
            ['name' => 'role-list'],
            ['name' => 'role-create'],
            ['name' => 'role-edit'],
            ['name' => 'role-delete'],

            //Trainees
            ['name' => 'trainee-list'],
            ['name' => 'trainee-create'],
            ['name' => 'trainee-accept'],
            ['name' => 'trainee-edit'],
            ['name' => 'trainee-delete'],

            //Advisor
            ['name' => 'advisor-list'],
            ['name' => 'advisor-create'],
            ['name' => 'advisor-edit'],
            ['name' => 'advisor-delete'],
            ['name' => 'advisor-accept'],

            //Field
            ['name' => 'field-list'],
            ['name' => 'field-create'],
            ['name' => 'field-edit'],
            ['name' => 'field-delete'],

            //Programmes
            ['name' => 'Programme-list'],
            ['name' => 'Programme-create'],
            ['name' => 'Programme-edit'],
            ['name' => 'Programme-delete'],
            ['name' => 'Programme-accept'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 1]);
        }
    }
}

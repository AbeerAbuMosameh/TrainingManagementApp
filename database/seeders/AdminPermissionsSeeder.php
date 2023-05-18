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
            //UserManagement
            //Roles
            ['name' => 'role-list'],
            ['name' => 'role-create'],
            ['name' => 'role-edit'],
            ['name' => 'role-delete'],
            //Users
            ['name' => 'trainee-list'],
            ['name' => 'trainee-create'],
            ['name' => 'trainee-accept'],
            ['name' => 'trainee-edit'],
            ['name' => 'trainee-delete'],

            //Companies
            ['name' => 'advisor-list'],
            ['name' => 'advisor-create'],
            ['name' => 'advisor-edit'],
            ['name' => 'advisor-delete'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 1]);
        }
    }
}

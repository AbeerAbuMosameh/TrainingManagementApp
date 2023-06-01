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
         //  ['name' => 'home'],
//
            //Roles
            ['name' => 'role-list'],
            ['name' => 'role-create'],
            ['name' => 'role-edit'],
            ['name' => 'role-delete'],

            //Trainees
            ['name' => 'admin-trainee-list'],
            ['name' => 'admin-trainee-create'],
            ['name' => 'admin-trainee-accept'],
            ['name' => 'admin-trainee-edit'],
            ['name' => 'admin-trainee-delete'],

            //Advisor
            ['name' => 'admin-advisor-list'],
            ['name' => 'admin-advisor-create'],
            ['name' => 'admin-advisor-edit'],
            ['name' => 'admin-advisor-delete'],
            ['name' => 'admin-advisor-accept'],

            //Field
            ['name' => 'admin-field-list'],
            ['name' => 'admin-field-create'],
            ['name' => 'admin-field-edit'],
            ['name' => 'admin-field-delete'],

            //Programs
            ['name' => 'admin-program-list'],
            ['name' => 'admin-program-create'],
            ['name' => 'admin-program-edit'],
            ['name' => 'admin-program-delete'],
            ['name' => 'admin-program-accept'],
            ['name' => 'admin-program-alltask'],
            ['name' => 'admin-program-alltrainee'],

            //payment
            ['name' => 'admin-payment-list'],
            ['name' => 'admin-payment-create'],
            ['name' => 'admin-payment-edit'],
            ['name' => 'admin-payment-delete'],

            //TraineeRequest
            ['name' => 'admin-trainee-requests-list'],
            ['name' => 'admin-trainee-requests-changeStatus'],

            //BillingIssues
            ['name' => 'admin-BillingIssues-List'],
            ['name' => 'admin-BillingIssues-change'],

            //General
            ['name' => 'admin-password-list'],
            ['name' => 'admin-password-edit'],

            ['name' => 'admin-logfile-download'],


        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 1]);
        }
    }
}

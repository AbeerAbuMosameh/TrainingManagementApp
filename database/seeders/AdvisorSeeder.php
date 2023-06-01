<?php

namespace Database\Seeders;

use App\Models\Advisor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdvisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Advisor::create([

                'id' => 1,
                'image' => null,
                'first_name' => 'Abeer',
                'last_name' => 'Abu Mosameh',
                'email' => 'abeermosameh1@gmail.com',
                'phone' => 'Abeer',
                'education' => 'Bachelor Degree',
                'address' => 'test',
                'city' => 'Gaza',
                'language' => 'test',
                'cv' => 'CVs/1692979316.cloud app requirements.pdf',
                'certification' => 'Certifications/1690600538.download.jpeg',
                'otherFile' => 'otherfile.txt',
                'is_approved' => 0,
                'password' => bcrypt('123456'),
                'notification_id' => 1,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);


            $advisor = User::create([
                'name' => 'Abeer Abu Mosameh',
                'email' => 'abeermosameh1@gmail.com',
                'password' => Hash::make('123456'),
                'level'=> '2'
            ]);

        $role = Role::create(['name' => 'advisor', 'level' => 2]);

        $permissions = Permission::where(['level' => 2])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $advisor->assignRole([$role->id]);

    }
}

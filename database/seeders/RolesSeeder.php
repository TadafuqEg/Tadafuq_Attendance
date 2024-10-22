<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       //create role "Employee" for users
        $roles = [
            'Client',
            'Admin',
            
        // Add more roles as needed
        ];

        foreach ($roles as $role) {
            $existed_role=Role::where('name' , $role)->first();
            if(!$existed_role){
                Role::create(['name' => $role]);
            }
        }
        $admin_role = Role::where('name','Admin')->first();
        

        $permissions = Permission::pluck('id', 'id')->all();

        $admin_role->syncPermissions($permissions);
        $admin1 = User::create([
            'name' => 'Admin1',
            'username'=>'admin1',
            'email' => 'admin1@gmail.com',
            'theme'=>'theme1',
            'password' => Hash::make('gmadmin159!48@26#1'),
        ]);
        $admin2 = User::create([
            'name' => 'Admin2',
            'username'=>'admin2',
            'email' => 'admin2@gmail.com',
            'theme'=>'theme2',
            'password' => Hash::make('gmadmin159!48@26#2'),
        ]);
        $admin3 = User::create([
            'name' => 'Admin3',
            'username'=>'admin3',
            'email' => 'admin3@gmail.com',
            'theme'=>'theme3',
            'password' => Hash::make('gmadmin159!48@26#3'),
        ]);
        $admin4 = User::create([
            'name' => 'Admin4',
            'username'=>'admin4',
            'email' => 'admin4@gmail.com',
            'theme'=>'theme4',
            'password' => Hash::make('gmadmin159!48@26#4'),
        ]);
        $admin5 = User::create([
            'name' => 'Admin5',
            'username'=>'admin5',
            'email' => 'admin5@gmail.com',
            'theme'=>'theme5',
            'password' => Hash::make('gmadmin159!48@26#5'),
        ]);

        

        $admin1->assignRole([$admin_role->id]);
        $admin2->assignRole([$admin_role->id]);
        $admin3->assignRole([$admin_role->id]);
        $admin4->assignRole([$admin_role->id]);
        $admin5->assignRole([$admin_role->id]);

        $Client_role = Role::where('name','Client')->first();
        $user1 = User::create([
            'name' => 'Fathy Samir Fathy',
            'username'=>'Fathy',
            'email' => 'fathy.samir@tadafuq.ae',
            
            'password' => Hash::make('123456789'),
        ]);
        $user2 = User::create([
            'name' => 'Michel Emad',
            'username'=>'michel',
            'email' => 'michael.emad@tadafuq.ae',
            
            'password' => Hash::make('123456789'),
        ]);
        $user1->assignRole([$Client_role->id]);
        $user2->assignRole([$Client_role->id]);
    }
}
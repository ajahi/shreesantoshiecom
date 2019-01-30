<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UsersPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'This account is for Admin',
        ]);
        $party = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('secret'),
        ]);

        $dreamsys = User::create([
            'name' => 'DreamSys',
            'email' =>'dreamsysitsolution@gmail.com',
            'password'=> bcrypt('secret'),
        ]);

        $user_role = Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'This account is for User',
        ]);

        $super_role = Role::create([
            'name' => 'super_admin',
            'display_name' => 'Super admin',
            'description' => 'This account is for Super user',
        ]);

        $super = User::create([
            'name' => 'Super User',
            'email' =>'super@super.com',
            'password'=> bcrypt('secret'),
        ]);
        $role_user = [
            [
                'user_id' => $party->id,
                'role_id' => $admin_role->id
            ],
            [
                'user_id' => $dreamsys->id,
                'role_id' => $admin_role->id
            ],
            [
                'user_id' => $super->id,
                'role_id' => $super_role->id
            ]
        ];
        DB::table('role_user')->insert($role_user);
    }

}

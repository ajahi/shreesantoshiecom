<?php

use App\Modules\User\Models\Role;
use App\Modules\User\Models\User;
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

        $role_user = [
            [
                'user_id' => $party->id,
                'role_id' => $admin_role->id
            ],
            [
                'user_id' => $dreamsys->id,
                'role_id' => $admin_role->id
            ]
        ];
        DB::table('role_user')->insert($role_user);
    }

}

<?php

use Illuminate\Database\Seeder;
use App\Laravue\Acl;
use App\Laravue\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            'Rasto Skubal',
            'Matej Strmen'
        ];

        foreach ($userList as $fullName) {
            $name = str_replace(' ', '.', $fullName);
            $roleName =
                Acl::ROLE_MANAGER;
            $user = \App\Laravue\Models\User::create([
                'name' => $fullName,
                'email' => strtolower($name) . '@krajinka.online',
                'password' => \Illuminate\Support\Facades\Hash::make('krajinka2018'),
                'avatar' => '/images/avataaars_v.svg',
            ]);

            $role = Role::findByName($roleName);
            $user->syncRoles($role);
        }
    }
}

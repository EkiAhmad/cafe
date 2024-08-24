<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //superadmin
        User::updateOrCreate([
            'username' => 'admin',
            'fullname' => 'Developer Super Admin',
            // 'password' => Hash::make("admin123"),
            'email' => 'adminDev@gmail.dev',
            'role' => 'superadmin',
            'created_by' => 0,
        ], [
            'username' => 'admin',
            'fullname' => 'Developer Super Admin',
            'password' => Hash::make("admin123"),
            'email' => 'adminDev@gmail.dev',
            'role' => 'superadmin',
            'created_by' => 0,
        ]);

        //owner
        User::updateOrCreate([
            'username' => 'owner_0',
            'fullname' => 'Developer Owner',
            // 'password' => Hash::make("owner123"),
            'email' => 'ownerDev@gmail.dev',
            'role' => 'owner',
            'created_by' => 0,
        ], [
            'username' => 'owner_0',
            'fullname' => 'Developer Owner',
            'password' => Hash::make("owner123"),
            'email' => 'ownerDev@gmail.dev',
            'role' => 'owner',
            'created_by' => 0,
        ]);

        //manager
        User::updateOrCreate([
            'username' => 'manager_0',
            'fullname' => 'Developer Manager',
            // 'password' => Hash::make("manager123"),
            'email' => 'managerDev@gmail.dev',
            'role' => 'manager',
            'created_by' => 0,
        ], [
            'username' => 'manager_0',
            'fullname' => 'Developer Manager',
            'password' => Hash::make("manager123"),
            'email' => 'managerDev@gmail.dev',
            'role' => 'manager',
            'created_by' => 0,
        ]);
    }
}

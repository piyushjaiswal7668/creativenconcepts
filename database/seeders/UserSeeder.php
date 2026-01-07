<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@creativenconcepts.com'],
            [
                'name' => 'Super Admin User',
                'phone' => '9999999990',
                'password' => Hash::make('SuperAdmin@12345'),
                'status' => 'active',
            ]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@creativenconcepts.com'],
            [
                'name' => 'Admin User',
                'phone' => '9999999999',
                'password' => Hash::make('Admin@12345'),
                'status' => 'active',
            ]
        );

        $editor = User::firstOrCreate(
            ['email' => 'editor@creativenconcepts.com'],
            [
                'name' => 'Editor User',
                'phone' => '8888888888',
                'password' => Hash::make('Editor@12345'),
                'status' => 'active',
            ]
        );

        $sales = User::firstOrCreate(
            ['email' => 'sales@creativenconcepts.com'],
            [
                'name' => 'Sales User',
                'phone' => '7777777777',
                'password' => Hash::make('Sales@12345'),
                'status' => 'active',
            ]
        );

        $superAdmin->syncRoles('super_admin');
        $admin->syncRoles('admin');
        $editor->syncRoles('content_manager');
        $sales->syncRoles('sales');
    }
}

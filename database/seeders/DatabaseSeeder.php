<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'thelastpc24@gmail.com'],
            [
                'name' => 'Rahmadahya',
                'password' => Hash::make('password')
            ]
        );

        $user = User::firstOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'User Dummy',
                'password' => Hash::make('password')
            ]
        );

        $permissions = [
            'view dashboard',

            'view user',
            'edit user',
            'delete user',

            'view role',
            'edit role',
            'delete role',

            'view product-category',
            'edit product-category',
            'delete product-category',

            'view product',
            'edit product',
            'delete product',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $role = Role::firstOrCreate(['name' => 'admin']);

        $staffRole = Role::firstOrCreate(['name' => 'staff']);

        $role->syncPermissions($permissions);
        $staffRole->syncPermissions($permissions);

        if (!$admin->hasRole($role->name)) {
            $admin->assignRole($role);
        }

        if (!$user->hasRole($role->name)) {
            $user->assignRole($staffRole);
        }
    }
}

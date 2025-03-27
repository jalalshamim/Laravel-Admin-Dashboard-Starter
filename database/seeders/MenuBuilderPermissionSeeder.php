<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuBuilderPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create menu builder permissions
        $permissions = [
            'menu-builder.view',
            'menu-builder.create',
            'menu-builder.edit',
            'menu-builder.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'admin']);
        }

        // Assign permissions to admin role
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permissions);
        }
    }
} 
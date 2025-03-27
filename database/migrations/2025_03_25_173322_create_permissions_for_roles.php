<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find existing roles or create them if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        
        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign roles',
            
            // Content permissions
            'view content',
            'create content',
            'edit content',
            'delete content',
            
            // Settings permissions
            'manage settings',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
        
        // Give admin role all permissions
        $adminRole->givePermissionTo($permissions);
        
        // Give user role only view content permission
        $userRole->givePermissionTo('view content');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to remove roles and permissions in the down method
        // as it could break existing data
    }
};

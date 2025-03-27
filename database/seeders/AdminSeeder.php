<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);

        $admin = Admin::where('email', 'admin@admin.com')->first();
        
        if ($admin) {
            $admin->update([
                'password' => Hash::make('password'),
                'is_super_admin' => true,
                'is_active' => true,
            ]);
            $admin->assignRole('admin');
            $this->command->info('Admin password updated successfully.');
        } else {
            $admin = Admin::create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('password'),
                'is_super_admin' => true,
                'is_active' => true,
            ]);
            $admin->assignRole('admin');
            $this->command->info('Admin created successfully.');
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Create permissions
        $permissions = [
            // User management
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Role management
            'view_roles',
            'create_roles',
            'edit_roles',
            'delete_roles',

            // Permission management
            'view_permissions',
            'create_permissions',
            'edit_permissions',
            'delete_permissions',

            // Dashboard
            'view_dashboard',

            // Reports
            'view_reports',
            'generate_reports',
            'export_reports',
            'delete_reports',
            'edit_reports',

            // Profile
            'view_own_profile',
            'edit_own_profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $viewerRole = Role::firstOrCreate(['name' => 'viewer']);

        // Assign permissions to admin role
        $adminRole->syncPermissions([
            'view users', 'create users', 'edit users', 'delete users',
            'view roles', 'create roles', 'edit roles', 'delete roles',
            'view permissions', 'create permissions', 'edit permissions', 'delete permissions',
            'view dashboard', 'view reports', 'generate reports', 'export reports', 'delete reports', 'edit reports',
            'view own profile', 'edit own profile',
        ]);

        // Assign permissions to editor role
        $editorRole->syncPermissions([
            'view dashboard', 'view reports', 'generate reports', 'export reports', 'edit reports',
            'view own profile', 'edit own profile',
        ]);

        // Assign permissions to viewer role
        $viewerRole->syncPermissions([
            'view dashboard', 'view reports',
            'view own profile', 'edit own profile',
        ]);

    }
}

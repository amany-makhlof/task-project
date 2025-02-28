<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'create post',
            'edit own post',
            'edit any post',
            'delete own post',
            'delete any post',
            'approve post',
            'assign roles'
        ];

        // Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'api']);
        $userRole = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'api']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all()); // Full access
        $editorRole->givePermissionTo(['create post', 'edit own post', 'delete own post']);
        $userRole->givePermissionTo(['create post']);

        // Additional permissions can be assigned as needed
    }
}

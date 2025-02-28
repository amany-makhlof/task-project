<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminAndEditorSeeder extends Seeder
{
    public function run()
    {
        // Define permissions
        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'approve posts',
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }

        // Create roles if they do not exist
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'api']);
        $editorRole = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'api']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($permissions); // Admin has all permissions
        $editorRole->givePermissionTo(['create posts', 'edit posts']); // Editor can create & edit posts

        // Create Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password@123')]
        );
        $admin->assignRole($adminRole);

        // Create Editor user
        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'Editor', 'password' => bcrypt('password@123')]
        );
        $editor->assignRole($editorRole);
    }
}

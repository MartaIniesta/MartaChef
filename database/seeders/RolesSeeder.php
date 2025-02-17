<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create-posts', 'edit-posts', 'delete-posts', 'restore-posts', 'force-delete-posts', 'rate-posts',
            'create-comments', 'edit-comments', 'reply-comments', 'delete-comments',
            'view-dashboard', 'follow-users', 'unfollow-users', 'delete-users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $user = Role::firstOrCreate(['name' => 'user']);
        $moderator = Role::firstOrCreate(['name' => 'moderator']);

        $admin->syncPermissions(Permission::all());

        $user->syncPermissions([
            'create-posts', 'edit-posts', 'delete-posts', 'rate-posts',
            'create-comments', 'edit-comments', 'reply-comments', 'delete-comments',
            'follow-users', 'unfollow-users'
        ]);

        $moderator->syncPermissions([
            'delete-posts', 'restore-posts', 'force-delete-posts', 'delete-comments'
        ]);
    }
}

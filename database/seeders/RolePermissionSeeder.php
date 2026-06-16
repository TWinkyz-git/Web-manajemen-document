<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Permissions
        Permission::create(['name' => 'view_documents']);
        Permission::create(['name' => 'download_documents']);
        Permission::create(['name' => 'upload_documents']);
        Permission::create(['name' => 'edit_documents']);
        Permission::create(['name' => 'delete_documents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'manage_categories']);
        Permission::create(['name' => 'view_audit_logs']);

        // Buat Roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $staffRole = Role::create(['name' => 'staff']);

        // Assign Permissions ke Admin (semua)
        $adminRole->givePermissionTo([
            'view_documents',
            'download_documents',
            'upload_documents',
            'edit_documents',
            'delete_documents',
            'manage_users',
            'manage_categories',
            'view_audit_logs',
        ]);

        // Assign Permissions ke Manager
        $managerRole->givePermissionTo([
            'view_documents',
            'download_documents',
            'upload_documents',
            'edit_documents',
            'delete_documents',
            'view_audit_logs',
        ]);

        // Assign Permissions ke Staff
        $staffRole->givePermissionTo([
            'view_documents',
            'download_documents',
        ]);
    }
}
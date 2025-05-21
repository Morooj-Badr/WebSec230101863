<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'add_products',
            'edit_products',
            'delete_products',
            'show_users',
            'edit_users',
            'delete_users',
            'admin_users',
            'add_review'  // Adding the new permission
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Customer role if it doesn't exist
        $customerRole = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'web']);

        // Assign add_review permission to Customer role
        $customerRole->givePermissionTo('add_review');
    }
} 
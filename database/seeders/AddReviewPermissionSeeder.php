<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddReviewPermissionSeeder extends Seeder
{
    public function run()
    {
        // Create the permission
        $permission = Permission::create([
            'name' => 'add_review',
            'display_name' => 'Add Review',
            'guard_name' => 'web'
        ]);

        // Assign permission to Admin role
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($permission);
        }

        // Assign permission to Customer role
        $customerRole = Role::where('name', 'Customer')->first();
        if ($customerRole) {
            $customerRole->givePermissionTo($permission);
        }
    }
} 
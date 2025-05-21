<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

// Check if permission exists
$permission = Permission::where('name', 'add_review')->first();
echo "Permission exists: " . ($permission ? "Yes" : "No") . "\n";

// Check Customer role
$customerRole = Role::where('name', 'Customer')->first();
echo "Customer role exists: " . ($customerRole ? "Yes" : "No") . "\n";

// Check if Customer role has the permission
if ($customerRole) {
    echo "Customer role has add_review permission: " . ($customerRole->hasPermissionTo('add_review') ? "Yes" : "No") . "\n";
}

// Check user2
$user = User::where('email', 'user2@mail.com')->first();
if ($user) {
    echo "User2 exists: Yes\n";
    echo "User2 has Customer role: " . ($user->hasRole('Customer') ? "Yes" : "No") . "\n";
    echo "User2 has add_review permission: " . ($user->hasPermissionTo('add_review') ? "Yes" : "No") . "\n";
} else {
    echo "User2 not found\n";
} 
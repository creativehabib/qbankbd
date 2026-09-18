<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Spatie cache clear
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::firstOrCreate(['name' => 'manage_media', 'guard_name' => 'web']);

        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo($permission);
        }

        $admin = Role::where('name', 'admin')->first();
        if ($admin) {
            $admin->givePermissionTo($permission);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permission = Permission::where('name', 'manage_media')->first();
        if ($permission) {
            $permission->delete();
        }
    }
};

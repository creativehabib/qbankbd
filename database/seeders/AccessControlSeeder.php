<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class AccessControlSeeder extends Seeder
{
    /**
     * Seed role and permission defaults.
     */
    public function run(): void
    {
        $permissionSlugs = [
            'questions.read',
            'questions.read_all',
            'questions.create',
            'questions.update',
            'questions.delete',
            'questions.publish',
            'users.manage_roles',
            'users.manage_permissions',
        ];

        foreach ($permissionSlugs as $permissionSlug) {
            Permission::query()->updateOrCreate(
                ['name' => $permissionSlug, 'guard_name' => 'web']
            );
        }

        $roles = ['student', 'teacher', 'admin', 'super_admin'];

        foreach ($roles as $roleName) {
            Role::query()->updateOrCreate(
                ['name' => $roleName, 'guard_name' => 'web']
            );
        }

        $roleMap = [
            'student' => ['questions.read'],
            'teacher' => ['questions.read', 'questions.create', 'questions.update', 'questions.delete'],
            'admin' => ['questions.read', 'questions.read_all', 'questions.create', 'questions.update', 'questions.delete', 'questions.publish'],
            'super_admin' => ['questions.read', 'questions.read_all', 'questions.create', 'questions.update', 'questions.delete', 'questions.publish', 'users.manage_roles', 'users.manage_permissions'],
        ];

        foreach ($roleMap as $roleName => $permissions) {
            Role::findByName($roleName, 'web')->syncPermissions($permissions);
        }

        User::query()->chunkById(100, function ($users): void {
            foreach ($users as $user) {
                if (! $user->roles()->exists()) {
                    $user->assignRole('student');
                }
            }
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

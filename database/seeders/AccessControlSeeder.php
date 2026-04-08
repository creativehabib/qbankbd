<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccessControlSeeder extends Seeder
{
    /**
     * Seed role and permission defaults.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Read Questions', 'slug' => 'questions.read'],
            ['name' => 'Read All Questions', 'slug' => 'questions.read_all'],
            ['name' => 'Create Questions', 'slug' => 'questions.create'],
            ['name' => 'Update Questions', 'slug' => 'questions.update'],
            ['name' => 'Delete Questions', 'slug' => 'questions.delete'],
            ['name' => 'Publish Questions', 'slug' => 'questions.publish'],
            ['name' => 'Manage Roles', 'slug' => 'users.manage_roles'],
            ['name' => 'Manage Permissions', 'slug' => 'users.manage_permissions'],
        ];

        foreach ($permissions as $permission) {
            Permission::query()->updateOrCreate(
                ['slug' => $permission['slug']],
                ['name' => $permission['name']]
            );
        }

        $roles = [
            ['name' => 'Student', 'slug' => 'student'],
            ['name' => 'Teacher', 'slug' => 'teacher'],
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Super Admin', 'slug' => 'super_admin'],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(
                ['slug' => $role['slug']],
                ['name' => $role['name'], 'guard' => 'web']
            );
        }

        $roleMap = [
            'student' => ['questions.read'],
            'teacher' => ['questions.read', 'questions.create', 'questions.update', 'questions.delete'],
            'admin' => ['questions.read', 'questions.read_all', 'questions.create', 'questions.update', 'questions.delete', 'questions.publish'],
            'super_admin' => ['questions.read', 'questions.read_all', 'questions.create', 'questions.update', 'questions.delete', 'questions.publish', 'users.manage_roles', 'users.manage_permissions'],
        ];

        DB::table('role_permissions')->delete();

        $permissionIds = Permission::query()->pluck('id', 'slug');
        $roleIds = Role::query()->pluck('id', 'slug');
        $now = now();

        foreach ($roleMap as $role => $permissionSlugs) {
            foreach ($permissionSlugs as $permissionSlug) {
                $permissionId = $permissionIds[$permissionSlug] ?? null;
                $roleId = $roleIds[$role] ?? null;

                if ($permissionId !== null && $roleId !== null) {
                    DB::table('role_permissions')->insert([
                        'role' => $role,
                        'role_id' => $roleId,
                        'permission_id' => $permissionId,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }
}

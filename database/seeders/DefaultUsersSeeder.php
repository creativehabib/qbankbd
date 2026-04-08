<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    /**
     * Seed application default users.
     */
    public function run(): void
    {
        $defaultPassword = 'password';
        $roleIds = Role::query()->pluck('id', 'slug');

        User::query()->updateOrCreate(
            ['email' => 'superadmin@qbank.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($defaultPassword),
                'role' => 'super_admin',
                'role_id' => $roleIds['super_admin'] ?? null,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@qbank.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make($defaultPassword),
                'role' => 'admin',
                'role_id' => $roleIds['admin'] ?? null,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'teacher@qbank.test'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make($defaultPassword),
                'role' => 'teacher',
                'role_id' => $roleIds['teacher'] ?? null,
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'student@qbank.test'],
            [
                'name' => 'Student User',
                'password' => Hash::make($defaultPassword),
                'role' => 'student',
                'role_id' => $roleIds['student'] ?? null,
                'email_verified_at' => now(),
            ]
        );
    }
}

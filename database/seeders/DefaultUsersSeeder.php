<?php

namespace Database\Seeders;

use App\Models\User;
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

        User::query()->updateOrCreate(
            ['email' => 'superadmin@qbank.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($defaultPassword),
                'role' => 'super_admin',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'admin@qbank.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make($defaultPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'teacher@qbank.test'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make($defaultPassword),
                'role' => 'teacher',
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'student@qbank.test'],
            [
                'name' => 'Student User',
                'password' => Hash::make($defaultPassword),
                'role' => 'student',
                'email_verified_at' => now(),
            ]
        );
    }
}

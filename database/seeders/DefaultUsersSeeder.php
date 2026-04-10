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

        $users = [
            ['email' => 'superadmin@qbank.test', 'name' => 'Super Admin', 'role' => 'super_admin'],
            ['email' => 'admin@qbank.test', 'name' => 'Admin User', 'role' => 'admin'],
            ['email' => 'teacher@qbank.test', 'name' => 'Teacher User', 'role' => 'teacher'],
            ['email' => 'student@qbank.test', 'name' => 'Student User', 'role' => 'student'],
        ];

        foreach ($users as $userData) {
            $user = User::query()->updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make($defaultPassword),
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$userData['role']]);
        }
    }
}

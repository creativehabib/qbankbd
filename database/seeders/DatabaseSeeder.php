<?php

namespace Database\Seeders;

use Database\Seeders\PackageSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PackageSeeder::class,
            AccessControlSeeder::class,
            DefaultUsersSeeder::class,
        ]);
    }
}

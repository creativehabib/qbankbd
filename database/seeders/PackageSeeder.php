<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            ['name' => 'Starter', 'price' => 3000, 'question_create_limit' => 3000, 'page_view_limit' => null, 'is_ad_free' => true, 'validity_days' => 30, 'is_active' => true],
            ['name' => 'Growth', 'price' => 5000, 'question_create_limit' => 6000, 'page_view_limit' => null, 'is_ad_free' => true, 'validity_days' => 60, 'is_active' => true],
            ['name' => 'Premium', 'price' => 9000, 'question_create_limit' => 12000, 'page_view_limit' => null, 'is_ad_free' => true, 'validity_days' => 90, 'is_active' => true],
        ];

        foreach ($packages as $package) {
            Package::query()->updateOrCreate(['name' => $package['name']], $package);
        }
    }
}

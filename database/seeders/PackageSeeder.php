<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::create([
            'name' => 'Pro Monthly Subscription',
            'type' => 'subscription',
            'price' => 200,
            'description' => 'Unlock all premium tests for 30 days',
            'validity_days' => 30,
            'is_active' => true,
        ]);

        Package::create([
            'name' => 'Pro Yearly Subscription',
            'type' => 'subscription',
            'price' => 2000,
            'description' => 'Save 16% on annual billing',
            'validity_days' => 365,
            'is_active' => true,
        ]);

        Package::create([
            'name' => '46th BCS Special Model Tests',
            'type' => 'course',
            'price' => 500,
            'description' => 'Exclusive model tests designed specifically for 46th BCS preparation.',
            'validity_days' => 90,
            'is_active' => true,
        ]);
    }
}

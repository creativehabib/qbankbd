<?php

use App\Models\Package;
use App\Models\User;

it('shows checkout page with payment methods for teacher', function () {
    $teacher = User::factory()->teacher()->create();

    $package = Package::query()->create([
        'name' => 'Pro Plan',
        'price' => 999,
        'validity_days' => 30,
        'question_create_limit' => 100,
        'page_view_limit' => 10000,
        'is_ad_free' => true,
        'is_active' => true,
    ]);

    $this->actingAs($teacher)
        ->get(route('teacher.pricing.checkout', $package))
        ->assertOk()
        ->assertSee('Select Payment Method')
        ->assertSee('A/C Balance')
        ->assertSee('bKash')
        ->assertSee('Nagad')
        ->assertSee('SSLCOMMERZ')
        ->assertSee('Manual Payment');
});

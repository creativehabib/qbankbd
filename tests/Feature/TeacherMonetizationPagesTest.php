<?php

use App\Models\User;

it('teacher can access subscription and monetization pages', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('teacher.subscription'))
        ->assertOk();

    $this->actingAs($teacher)
        ->get(route('teacher.pricing'))
        ->assertOk();

    $this->actingAs($teacher)
        ->get(route('teacher.earnings'))
        ->assertOk();

    $this->actingAs($teacher)
        ->get(route('teacher.wallet'))
        ->assertOk();
});

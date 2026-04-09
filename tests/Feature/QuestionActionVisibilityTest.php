<?php

use App\Livewire\Questions;
use App\Models\User;
use Livewire\Livewire;

it('shows create button when user has create permission', function () {
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(Questions::class)
        ->assertSee('New Question');
});

it('hides create button when user does not have create permission', function () {
    $student = User::factory()->create();

    Livewire::actingAs($student)
        ->test(Questions::class)
        ->assertDontSee('New Question');
});

<?php

use App\Livewire\OmrGenerator;
use App\Models\User;

it('allows teacher admin and super admin to access omr generator', function (string $state): void {
    $user = User::factory()->{$state}()->create();

    $this->actingAs($user)
        ->get(route('omr.generator'))
        ->assertOk()
        ->assertSeeLivewire(OmrGenerator::class);
})->with([
    'teacher',
    'admin',
    'superAdmin',
]);

it('forbids students from accessing omr generator', function (): void {
    $student = User::factory()->create();

    $this->actingAs($student)
        ->get(route('omr.generator'))
        ->assertForbidden();
});

it('shows omr generator in sidebar for teacher', function (): void {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee(route('omr.generator'), false)
        ->assertSee('OMR Generator');
});

it('does not show omr generator in sidebar for student', function (): void {
    $student = User::factory()->create();

    $this->actingAs($student)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertDontSee(route('omr.generator'), false)
        ->assertDontSee('OMR Generator');
});

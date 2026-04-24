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

<?php

use App\Livewire\OmrGenerator;
use App\Models\User;
use Livewire\Livewire;

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


it('supports dynamic omr settings updates', function (): void {
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(OmrGenerator::class)
        ->set('schoolName', 'ডেমো স্কুল')
        ->set('address', 'ঢাকা')
        ->set('questionCount', 60)
        ->set('headerSize', 'SMALL')
        ->set('infoType', 'MANUAL')
        ->call('updateTheme', 'green')
        ->assertSet('schoolName', 'ডেমো স্কুল')
        ->assertSet('address', 'ঢাকা')
        ->assertSet('questionCount', 60)
        ->assertSet('headerSize', 'SMALL')
        ->assertSet('infoType', 'MANUAL')
        ->assertSet('themeColor', 'green')
        ->assertSee('ডেমো স্কুল')
        ->assertSee('Questions: 60');
});

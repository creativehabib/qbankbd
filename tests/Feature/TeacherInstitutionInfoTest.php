<?php

use App\Livewire\Teacher\InstitutionInfo;
use App\Models\User;
use Livewire\Livewire;

it('teacher can update institution info from dashboard menu page', function () {
    $teacher = User::factory()->teacher()->create([
        'institution_name' => 'Old School',
        'institution_type' => 'School',
        'institution_address' => 'Old address',
    ]);

    $this->actingAs($teacher);

    Livewire::test(InstitutionInfo::class)
        ->set('institutionName', 'Dhaka College')
        ->set('institutionType', 'College')
        ->set('institutionAddress', 'Dhaka, Bangladesh')
        ->call('save')
        ->assertHasNoErrors();

    $teacher->refresh();

    expect($teacher->institution_name)->toBe('Dhaka College')
        ->and($teacher->institution_type)->toBe('College')
        ->and($teacher->institution_address)->toBe('Dhaka, Bangladesh');
});

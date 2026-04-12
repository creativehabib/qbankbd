<?php

use App\Livewire\Questions\Create;
use App\Models\User;
use Livewire\Livewire;

it('forbids students from submitting question create action', function () {
    $student = User::factory()->create();

    Livewire::actingAs($student)
        ->test(Create::class)
        ->call('save')
        ->assertForbidden();
});

it('allows teachers to access question create action without authorization errors', function () {
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(Create::class)
        ->call('save')
        ->assertHasErrors([
            'academic_class_id',
            'subject_id',
            'title',
            'question_type',
            'exam_category_ids',
            'slug',
        ]);
});

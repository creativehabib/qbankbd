<?php

use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

it('allows teachers to create questions based on permission policy', function () {
    $teacher = User::factory()->teacher()->create();

    expect(Gate::forUser($teacher)->allows('create', Question::class))->toBeTrue();
});

it('denies students from creating questions through the question policy', function () {
    $student = User::factory()->create();

    expect(Gate::forUser($student)->allows('create', Question::class))->toBeFalse();
});

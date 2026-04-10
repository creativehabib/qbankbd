<?php

use App\Models\User;

it('allows teachers to access academic structure management pages', function (string $routeName) {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route($routeName))
        ->assertOk();
})->with([
    'exam-categories.index',
    'academic-classes.index',
    'subjects.index',
    'chapters.index',
    'topics.index',
]);

it('forbids students from accessing academic structure management pages', function (string $routeName) {
    $student = User::factory()->create();

    $this->actingAs($student)
        ->get(route($routeName))
        ->assertForbidden();
})->with([
    'exam-categories.index',
    'academic-classes.index',
    'subjects.index',
    'chapters.index',
    'topics.index',
]);

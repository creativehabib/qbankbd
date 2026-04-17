<?php

use App\Livewire\Students\PracticeIndex;
use App\Models\AcademicClass;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Str;

test('student can access practice menu page', function () {
    $student = User::factory()->create();

    $this->actingAs($student)
        ->get(route('students.practice.index'))
        ->assertOk()
        ->assertSeeLivewire(PracticeIndex::class)
        ->assertSee('Select Topics for Practice');
});

test('practice page shows subject wise mcq counts', function () {
    $student = User::factory()->create();

    $academicClass = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $academicClass->id,
        'name' => 'গণিত',
        'slug' => 'gonit',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Sample MCQ Question',
        'slug' => 'sample-mcq-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $academicClass->id,
        'subject_id' => $subject->id,
    ]);

    $this->actingAs($student)
        ->get(route('students.practice.index'))
        ->assertOk()
        ->assertSee('গণিত')
        ->assertSee('0/1 MCQ');
});

test('teacher cannot access student practice page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('students.practice.index'))
        ->assertForbidden();
});

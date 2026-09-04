<?php

use App\Livewire\Students\TakeMockTest;
use App\Models\AcademicClass;
use App\Models\MockTest;
use App\Models\MockTestQuestion;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('student answers are kept in Alpine until submission and saved in one request', function (): void {
    $student = User::factory()->create(['xp' => 0]);
    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10-mock-test',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $class->id,
        'name' => 'Mathematics',
        'slug' => 'mathematics-mock-test',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $question = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Which option is correct?',
        'slug' => 'which-option-is-correct',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'extra_content' => [
            ['option_text' => 'Incorrect', 'is_correct' => false],
            ['option_text' => 'Correct', 'is_correct' => true],
        ],
    ]);
    $mockTest = MockTest::query()->create([
        'user_id' => $student->id,
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'total_questions' => 1,
        'duration_minutes' => 30,
        'started_at' => now(),
    ]);
    $testQuestion = MockTestQuestion::query()->create([
        'mock_test_id' => $mockTest->id,
        'question_id' => $question->id,
    ]);

    Livewire::actingAs($student)
        ->test(TakeMockTest::class, ['testId' => $mockTest->id])
        ->assertSee('x-model="answers['.$testQuestion->id.']"', false)
        ->call('submitExam', [$testQuestion->id => 1])
        ->assertRedirect(route('student.mock-test.result', ['testId' => $mockTest->id]));

    expect($mockTest->fresh())
        ->status->toBe('completed')
        ->correct_answers->toBe(1)
        ->wrong_answers->toBe(0);
    expect($testQuestion->fresh())
        ->user_answer->toBe('1')
        ->is_correct->toBeTrue();
    expect($student->fresh()->xp)->toBe(10);
});

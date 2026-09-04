<?php

use App\Livewire\Students\TakeMockTest;
use App\Models\AcademicClass;
use App\Models\MockTest;
use App\Models\MockTestQuestion;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('student can submit a mock test and earn XP only once', function () {
    $student = User::factory()->create(['xp' => 0]);

    $academicClass = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10-mock-test',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $academicClass->id,
        'name' => 'Mathematics',
        'slug' => 'mathematics-mock-test',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $question = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'What is 2 + 2?',
        'slug' => 'what-is-two-plus-two',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $academicClass->id,
        'subject_id' => $subject->id,
        'extra_content' => [
            ['option_text' => '4', 'is_correct' => true],
            ['option_text' => '5', 'is_correct' => false],
        ],
    ]);

    $mockTest = MockTest::query()->create([
        'user_id' => $student->id,
        'academic_class_id' => $academicClass->id,
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
        ->set("answers.{$testQuestion->id}", 0)
        ->call('submitExam')
        ->assertRedirect(route('student.mock-test.result', ['testId' => $mockTest->id]));

    $this->assertDatabaseHas('mock_tests', [
        'id' => $mockTest->id,
        'correct_answers' => 1,
        'wrong_answers' => 0,
        'status' => 'completed',
    ]);
    $this->assertDatabaseHas('mock_test_questions', [
        'id' => $testQuestion->id,
        'user_answer' => '0',
        'is_correct' => true,
    ]);
    expect($student->fresh()->xp)->toBe(10);

    Livewire::actingAs($student)
        ->test(TakeMockTest::class, ['testId' => $mockTest->id])
        ->assertRedirect(route('student.practice.index'));

    expect($student->fresh()->xp)->toBe(10);
});

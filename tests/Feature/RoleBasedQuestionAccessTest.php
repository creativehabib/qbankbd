<?php

use App\Livewire\Questions\QuestionIndex;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('students can only view active questions', function () {
    $student = User::factory()->create();

    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 9',
        'slug' => 'class-9',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $class->id,
        'name' => 'Bangla',
        'subject_code' => '102',
        'slug' => 'bangla',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Poetry',
        'chapter_no' => '1',
        'slug' => 'poetry',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Modern Poetry',
        'slug' => 'modern-poetry',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Active Question',
        'slug' => 'active-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Pending Question',
        'slug' => 'pending-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
    ]);

    Livewire::actingAs($student)
        ->test(QuestionIndex::class)
        ->assertSee('Active Question')
        ->assertDontSee('Pending Question');
});

it('students cannot create questions', function () {
    $student = User::factory()->create();

    Livewire::actingAs($student)
        ->test(QuestionIndex::class)
        ->call('openModal')
        ->assertForbidden();
});

it('teacher cannot edit another teachers question', function () {
    $teacherA = User::factory()->teacher()->create();
    $teacherB = User::factory()->teacher()->create();

    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 8',
        'slug' => 'class-8',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $class->id,
        'name' => 'English',
        'subject_code' => '103',
        'slug' => 'english',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Grammar',
        'chapter_no' => '1',
        'slug' => 'grammar',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $question = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Who wrote this sentence?',
        'slug' => 'who-wrote-this-sentence',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
        'is_premium' => false,
        'user_id' => $teacherA->id,
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => null,
    ]);

    Livewire::actingAs($teacherB)
        ->test(QuestionIndex::class)
        ->call('editQuestion', $question->id)
        ->assertNotFound();
});

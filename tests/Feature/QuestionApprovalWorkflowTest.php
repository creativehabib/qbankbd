<?php

use App\Livewire\Questions;
use App\Livewire\Questions\Create;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

function createQuestionDependencies(): array
{
    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $class->id,
        'name' => 'Mathematics',
        'subject_code' => '101',
        'slug' => 'mathematics',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Algebra',
        'chapter_no' => '1',
        'slug' => 'algebra',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Polynomials',
        'slug' => 'polynomials',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $examCategory = ExamCategory::query()->create([
        'name' => 'SSC',
        'slug' => 'ssc',
    ]);

    return [$subject, $chapter, $topic, $examCategory];
}

it('stores teacher created questions as pending', function () {
    $teacher = User::factory()->teacher()->create();
    [$subject, $chapter, $topic, $examCategory] = createQuestionDependencies();

    Livewire::actingAs($teacher)
        ->test(Create::class)
        ->set('subject_id', $subject->id)
        ->set('chapter_id', $chapter->id)
        ->set('topic_id', $topic->id)
        ->set('title', 'What is x if x + 2 = 5?')
        ->set('slug', 'what-is-x-if-x-2-5')
        ->set('description', 'Simple algebra question')
        ->set('difficulty', 'easy')
        ->set('question_type', 'mcq')
        ->set('marks', 1)
        ->set('options', [
            ['option_text' => '2', 'is_correct' => false],
            ['option_text' => '3', 'is_correct' => true],
        ])
        ->set('exam_category_ids', [$examCategory->id])
        ->call('save')
        ->assertHasNoErrors();

    $question = Question::query()->first();

    expect($question)->not->toBeNull();
    expect($question->status)->toBe('pending');
});

it('stores questions as active when creator has publish permission', function () {
    $teacher = User::factory()->teacher()->create();
    $teacher->givePermissionTo('questions.publish');
    [$subject, $chapter, $topic, $examCategory] = createQuestionDependencies();

    Livewire::actingAs($teacher)
        ->test(Create::class)
        ->set('subject_id', $subject->id)
        ->set('chapter_id', $chapter->id)
        ->set('topic_id', $topic->id)
        ->set('title', 'What is x if x + 3 = 6?')
        ->set('slug', 'what-is-x-if-x-3-6')
        ->set('description', 'Simple algebra question')
        ->set('difficulty', 'easy')
        ->set('question_type', 'mcq')
        ->set('marks', 1)
        ->set('options', [
            ['option_text' => '2', 'is_correct' => false],
            ['option_text' => '3', 'is_correct' => true],
        ])
        ->set('exam_category_ids', [$examCategory->id])
        ->call('save')
        ->assertHasNoErrors();

    $question = Question::query()->where('slug', 'what-is-x-if-x-3-6')->first();

    expect($question)->not->toBeNull();
    expect($question->status)->toBe('active');
});

it('allows admin to toggle question status from the question list', function () {
    $admin = User::factory()->admin()->create();

    $question = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Pending algebra question',
        'slug' => 'pending-algebra-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
        'user_id' => $admin->id,
    ]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('toggleQuestionStatus', $question->id)
        ->assertHasNoErrors();

    expect($question->fresh()->status)->toBe('active');

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('toggleQuestionStatus', $question->id)
        ->assertHasNoErrors();

    expect($question->fresh()->status)->toBe('pending');
});

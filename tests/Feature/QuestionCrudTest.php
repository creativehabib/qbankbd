<?php

use App\Livewire\Questions\Create;
use App\Livewire\Questions\QuestionIndex;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('creates updates and deletes a question from the livewire crud screen', function () {
    $teacher = User::factory()->teacher()->create();
    $admin = User::factory()->admin()->create();

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

    Livewire::actingAs($teacher)
        ->test(QuestionIndex::class)
        ->set('subject_id', $subject->id)
        ->set('chapter_id', $chapter->id)
        ->set('topic_id', $topic->id)
        ->set('title', 'What is x if x + 2 = 5?')
        ->set('description', 'Simple algebra question')
        ->set('difficulty', 'easy')
        ->set('question_type', 'mcq')
        ->set('marks', 1)
        ->set('status', 'active')
        ->set('exam_category_ids', [$examCategory->id])
        ->call('saveQuestion')
        ->assertHasNoErrors();

    $question = Question::query()->first();

    expect($question)->not->toBeNull();
    expect($question->slug)->toBe('what-is-x-if-x-2-5');
    expect($question->status)->toBe('pending');

    Livewire::actingAs($admin)
        ->test(QuestionIndex::class)
        ->call('editQuestion', $question->id)
        ->set('title', 'Updated algebra question')
        ->set('difficulty', 'medium')
        ->set('marks', 2)
        ->set('status', 'active')
        ->call('saveQuestion')
        ->assertHasNoErrors();

    $question->refresh();

    expect($question->title)->toBe('Updated algebra question');
    expect((float) $question->marks)->toBe(2.0);
    expect($question->status)->toBe('active');

    Livewire::actingAs($admin)
        ->test(QuestionIndex::class)
        ->call('deleteQuestion', $question->id);

    expect(Question::withTrashed()->find($question->id)?->deleted_at)->not->toBeNull();
});


it('applies border styles to slug difficulty type and marks inputs on create form', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Create::class)
        ->assertSeeHtml('id="slug_input"')
        ->assertSeeHtml('class="block w-full rounded-md border border-gray-300 shadow-sm sm:text-sm transition-colors dark:border-gray-600 dark:text-white"')
        ->assertSeeHtml('wire:model="difficulty" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200 appearance-none"')
        ->assertSeeHtml('wire:model.live="question_type" class="block w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200"')
        ->assertSeeHtml('wire:model.live="marks"')
        ->assertSeeHtml('class="block w-full rounded-md border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:text-gray-200 pr-12"');
});

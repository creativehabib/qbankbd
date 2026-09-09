<?php

use App\Livewire\Questions;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

function createModerationQuestionDependencies(): array
{
    $academicClass = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10-moderation',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $academicClass->id,
        'name' => 'Mathematics',
        'subject_code' => '101',
        'slug' => 'mathematics-moderation',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Algebra',
        'chapter_no' => '1',
        'slug' => 'algebra-moderation',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Polynomials',
        'slug' => 'polynomials-moderation',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    return [$academicClass, $subject, $chapter, $topic];
}

it('filters questions through the class subject chapter and topic hierarchy', function () {
    $admin = User::factory()->admin()->create();
    [$academicClass, $subject, $chapter, $topic] = createModerationQuestionDependencies();

    $matchingQuestion = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $admin->id,
        'academic_class_id' => $academicClass->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
        'title' => 'Polynomial question',
        'slug' => 'polynomial-question-moderation',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
    ]);

    $otherQuestion = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $admin->id,
        'academic_class_id' => $academicClass->id,
        'subject_id' => $subject->id,
        'title' => 'Subject-only question',
        'slug' => 'subject-only-question-moderation',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
    ]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->set('academicClassId', $academicClass->id)
        ->set('subjectId', $subject->id)
        ->set('chapterId', $chapter->id)
        ->set('topicId', $topic->id)
        ->assertSee($matchingQuestion->title)
        ->assertDontSee($otherQuestion->title);
});

it('moves selected questions to trash then restores and permanently deletes them', function () {
    $admin = User::factory()->admin()->create();
    [$academicClass, $subject, $chapter, $topic] = createModerationQuestionDependencies();

    $question = Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'user_id' => $admin->id,
        'academic_class_id' => $academicClass->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
        'title' => 'Question for trash workflow',
        'slug' => 'question-for-trash-workflow',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'pending',
    ]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->set('selectedQuestionIds', [$question->id])
        ->call('confirmAction', 'trash')
        ->call('executeConfirmation');

    $this->assertSoftDeleted('questions', ['id' => $question->id]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('setQuickFilter', 'trash')
        ->set('selectedQuestionIds', [$question->id])
        ->call('confirmAction', 'restore')
        ->call('executeConfirmation');

    $this->assertDatabaseHas('questions', ['id' => $question->id, 'deleted_at' => null]);

    $question->delete();

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('setQuickFilter', 'trash')
        ->set('selectedQuestionIds', [$question->id])
        ->call('confirmAction', 'force_delete')
        ->call('executeConfirmation');

    $this->assertDatabaseMissing('questions', ['id' => $question->id]);
});

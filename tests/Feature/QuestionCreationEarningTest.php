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
use App\Models\Wallet;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('pays teacher only when admin approves the question and marks is_paid true', function () {
    $teacher = User::factory()->teacher()->create();
    $admin = User::factory()->admin()->create();

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
        'name' => 'Physics',
        'subject_code' => '201',
        'slug' => 'physics',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Motion',
        'chapter_no' => '1',
        'slug' => 'motion',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Velocity',
        'slug' => 'velocity',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $examCategory = ExamCategory::query()->create([
        'name' => 'HSC',
        'slug' => 'hsc',
    ]);

    Livewire::actingAs($teacher)
        ->test(Create::class)
        ->set('academic_class_id', $class->id)
        ->set('subject_id', $subject->id)
        ->set('chapter_id', $chapter->id)
        ->set('topic_id', $topic->id)
        ->set('title', 'What is velocity?')
        ->set('slug', 'what-is-velocity')
        ->set('description', 'Definition based question')
        ->set('difficulty', 'easy')
        ->set('question_type', 'mcq')
        ->set('marks', 1)
        ->set('options', [
            ['option_text' => 'Speed with direction', 'is_correct' => true],
            ['option_text' => 'Speed without direction', 'is_correct' => false],
        ])
        ->set('exam_category_ids', [$examCategory->id])
        ->call('save')
        ->assertHasNoErrors();

    $question = Question::query()->where('slug', 'what-is-velocity')->firstOrFail();

    expect($question->status)->toBe('pending')
        ->and($question->is_paid)->toBeFalse();

    expect(Wallet::query()->where('user_id', $teacher->id)->doesntExist())->toBeTrue();

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('toggleQuestionStatus', $question->id)
        ->assertHasNoErrors();

    $question->refresh();
    $wallet = Wallet::query()->where('user_id', $teacher->id)->firstOrFail();

    expect($question->status)->toBe('active')
        ->and($question->is_paid)->toBeTrue()
        ->and((float) $wallet->reward_balance)->toBe(10.0);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('toggleQuestionStatus', $question->id)
        ->call('toggleQuestionStatus', $question->id)
        ->assertHasNoErrors();

    $wallet->refresh();

    expect((float) $wallet->reward_balance)->toBe(10.0);
});

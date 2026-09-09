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

it('shows create button when user has create permission', function () {
    $teacher = User::factory()->teacher()->create();

    Livewire::actingAs($teacher)
        ->test(Questions::class)
        ->assertSee('New Question');
});

it('adds left padding to question selection checkboxes', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->assertSeeHtml('class="w-16 pl-4"');
});

it('hides create button when user does not have create permission', function () {
    $student = User::factory()->create();

    Livewire::actingAs($student)
        ->test(Questions::class)
        ->assertDontSee('New Question');
});

it('activates taxonomy filters in class, subject, chapter sequence and shows question marks and payment columns', function () {
    $admin = User::factory()->admin()->create();

    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 9',
        'slug' => 'class-9',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $otherClass = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 2,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $class->id,
        'name' => 'Mathematics',
        'subject_code' => '109',
        'slug' => 'mathematics-9',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $otherSubject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $otherClass->id,
        'name' => 'Physics',
        'subject_code' => '110',
        'slug' => 'physics-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Algebra',
        'chapter_no' => '1',
        'slug' => 'algebra-9',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $otherChapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $otherSubject->id,
        'name' => 'Mechanics',
        'chapter_no' => '1',
        'slug' => 'mechanics-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Equations',
        'slug' => 'equations-9',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $otherChapter->id,
        'name' => 'Motion',
        'slug' => 'motion-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    Question::query()->create([
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
        'title' => 'Paid algebra question',
        'slug' => 'paid-algebra-question',
        'marks' => 5,
        'is_paid' => true,
        'status' => 'active',
        'user_id' => $admin->id,
    ]);
    Question::query()->create([
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'topic_id' => $topic->id,
        'title' => 'Unpaid algebra question',
        'slug' => 'unpaid-algebra-question',
        'marks' => 2,
        'is_paid' => false,
        'status' => 'active',
        'user_id' => $admin->id,
    ]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->set('academicClassId', (string) $class->id)
        ->assertSee('Mathematics')
        ->assertDontSee('Algebra')
        ->assertDontSee('Equations')
        ->assertDontSee('Physics')
        ->assertDontSee('Mechanics')
        ->assertDontSee('Motion')
        ->set('subjectId', (string) $subject->id)
        ->assertSee('Algebra')
        ->assertDontSee('Equations')
        ->set('chapterId', (string) $chapter->id)
        ->assertSee('Equations')
        ->assertSee('Paid algebra question')
        ->assertSee('Unpaid algebra question')
        ->assertSee('MARKS')
        ->assertSee('PAYMENT')
        ->assertSee('5')
        ->assertSee('PAID')
        ->assertSee('UNPAID');
});

it('shows a question’s options in the review modal', function () {
    $admin = User::factory()->admin()->create();
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
        'name' => 'Science',
        'subject_code' => '108',
        'slug' => 'science-8',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);
    $question = Question::query()->create([
        'academic_class_id' => $class->id,
        'subject_id' => $subject->id,
        'title' => 'Which option is correct?',
        'slug' => 'which-option-is-correct',
        'marks' => 1,
        'is_paid' => true,
        'status' => 'active',
        'extra_content' => [
            ['option_text' => 'First option', 'is_correct' => false],
            ['option_text' => 'Correct option', 'is_correct' => true],
        ],
        'user_id' => $admin->id,
    ]);

    Livewire::actingAs($admin)
        ->test(Questions::class)
        ->call('openQuestionModal', $question->id)
        ->assertSet('showQuestionModal', true)
        ->assertSee('Options')
        ->assertSee('First option')
        ->assertSee('Correct option')
        ->assertSee('Correct')
        ->assertSee('Paid');
});

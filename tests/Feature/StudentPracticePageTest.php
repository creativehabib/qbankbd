<?php

use App\Livewire\Students\PracticeIndex;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('student can access practice page and see class folders', function () {
    $student = User::factory()->create();

    $class = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $this->actingAs($student)
        ->get(route('students.practice.index'))
        ->assertOk()
        ->assertSeeLivewire(PracticeIndex::class)
        ->assertSee('Select Topics for Practice')
        ->assertSee($class->name);
});

test('subject list is shown after opening a class folder', function () {
    $student = User::factory()->create();

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $classNine = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 9',
        'slug' => 'class-9',
        'order_sequence' => 2,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subjectForClassTen = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classTen->id,
        'name' => 'গণিত',
        'slug' => 'gonit',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classNine->id,
        'name' => 'বাংলা',
        'slug' => 'bangla',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Sample MCQ Question',
        'slug' => 'sample-mcq-question',
        'difficulty' => 'easy',
        'description' => null,
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $classTen->id,
        'subject_id' => $subjectForClassTen->id,
        'extra_content' => [
            ['option_text' => 'Option A', 'is_correct' => true],
            ['option_text' => 'Option B', 'is_correct' => false],
        ],
    ]);

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->call('openClass', $classTen->id)
        ->assertSee('গণিত')
        ->assertSee('0/1 MCQ')
        ->assertDontSee('বাংলা');
});

test('chapter list is shown after opening a subject folder', function () {
    $student = User::factory()->create();

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classTen->id,
        'name' => 'গণিত',
        'slug' => 'gonit-livewire',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapterOne = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'বাস্তব সংখ্যা',
        'slug' => 'bastob-songkha',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'সেট',
        'slug' => 'set',
        'order_sequence' => 2,
        'is_active' => false,
        'is_premium' => false,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'Sample Chapter MCQ Question',
        'slug' => 'sample-chapter-mcq-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $classTen->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapterOne->id,
        'extra_content' => [
            ['option_text' => 'Option A', 'is_correct' => true],
            ['option_text' => 'Option B', 'is_correct' => false],
        ],
    ]);

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->call('openClass', $classTen->id)
        ->call('openSubject', $subject->id)
        ->assertSee('বাস্তব সংখ্যা')
        ->assertSee('0/1 MCQ')
        ->assertDontSee('সেট');
});

test('latest mcq questions are shown after opening a chapter folder', function () {
    $student = User::factory()->create();

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10-latest',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classTen->id,
        'name' => 'বাংলা ১ম পত্র',
        'slug' => 'bangla-1st-paper',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'গদ্য',
        'slug' => 'goddo',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => 'পুরনো এমসিকিউ প্রশ্ন',
        'slug' => 'old-mcq-question',
        'difficulty' => 'easy',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $classTen->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'extra_content' => [
            ['option_text' => 'ভুল উত্তর', 'is_correct' => false],
            ['option_text' => 'সঠিক উত্তর', 'is_correct' => true],
        ],
    ]);

    Question::query()->create([
        'uuid' => (string) Str::uuid(),
        'title' => '3+6+12+24+&hellip;+384 ধারাটির পদসংখ্যা কত ?',
        'slug' => 'latest-mcq-question',
        'difficulty' => 'medium',
        'description' => 'এটি একটি ব্যাখ্যা।',
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $classTen->id,
        'subject_id' => $subject->id,
        'chapter_id' => $chapter->id,
        'extra_content' => [
            ['option_text' => 'বাংলা', 'is_correct' => true],
            ['option_text' => 'ইংরেজি', 'is_correct' => false],
            ['option_text' => 'আরবি', 'is_correct' => false],
            ['option_text' => 'উর্দু', 'is_correct' => false],
        ],
    ]);

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->call('openClass', $classTen->id)
        ->call('openSubject', $subject->id)
        ->call('openChapter', $chapter->id)
        ->assertSee('3+6+12+24+…+384 ধারাটির পদসংখ্যা কত ?')
        ->assertDontSee('&hellip;')
        ->assertSee('বাংলা')
        ->assertSee('ইংরেজি')
        ->assertSee('পুরনো এমসিকিউ প্রশ্ন')
        ->assertSee('DES')
        ->assertSee('No explanation yet')
        ->assertSee('এটি একটি ব্যাখ্যা।');
});

test('teacher cannot access student practice page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('students.practice.index'))
        ->assertForbidden();
});

test('mcq question list shows pagination after 20 questions', function () {
    $student = User::factory()->create();

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10-pagination',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classTen->id,
        'name' => 'জীববিজ্ঞান',
        'slug' => 'biology-pagination',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'কোষ ও টিস্যু',
        'slug' => 'cell-and-tissue',
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    foreach (range(1, 21) as $sequence) {
        Question::query()->create([
            'uuid' => (string) Str::uuid(),
            'title' => "Pagination MCQ {$sequence}",
            'slug' => "pagination-mcq-{$sequence}",
            'difficulty' => 'easy',
            'question_type' => 'mcq',
            'marks' => 1,
            'status' => 'active',
            'is_premium' => false,
            'user_id' => $student->id,
            'academic_class_id' => $classTen->id,
            'subject_id' => $subject->id,
            'chapter_id' => $chapter->id,
            'extra_content' => [
                ['option_text' => 'Option A', 'is_correct' => true],
                ['option_text' => 'Option B', 'is_correct' => false],
            ],
        ]);
    }

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->call('openClass', $classTen->id)
        ->call('openSubject', $subject->id)
        ->call('openChapter', $chapter->id)
        ->assertSee('Pagination MCQ 21')
        ->assertDontSee('Pagination MCQ 1')
        ->assertSee('Next');
});

<?php

use App\Livewire\Students\PracticeIndex;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('student can access practice menu page and see class selector', function () {
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
        ->assertSee('শ্রেণি নির্বাচন করুন')
        ->assertSee($class->name);
});

test('subject list is shown after selecting a class', function () {
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
        'question_type' => 'mcq',
        'marks' => 1,
        'status' => 'active',
        'is_premium' => false,
        'user_id' => $student->id,
        'academic_class_id' => $classTen->id,
        'subject_id' => $subjectForClassTen->id,
    ]);

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->set('selectedClassId', $classTen->id)
        ->assertSee('গণিত')
        ->assertSee('0/1 MCQ')
        ->assertDontSee('বাংলা');
});

test('chapter list is shown after selecting a subject', function () {
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
    ]);

    Livewire::actingAs($student)
        ->test(PracticeIndex::class)
        ->set('selectedClassId', $classTen->id)
        ->call('selectSubject', $subject->id)
        ->assertSee('চ্যাপ্টার নির্বাচন করুন')
        ->assertSee('বাস্তব সংখ্যা')
        ->assertSee('0/1 MCQ')
        ->assertDontSee('সেট');
});

test('teacher cannot access student practice page', function () {
    $teacher = User::factory()->teacher()->create();

    $this->actingAs($teacher)
        ->get(route('students.practice.index'))
        ->assertForbidden();
});

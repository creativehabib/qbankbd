<?php

use App\Livewire\AcademicClasses\ClassIndex;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Str;
use Livewire\Livewire;

test('academic structure can be created from a single livewire page', function () {
    Livewire::test(ClassIndex::class)
        ->set('class_name', 'HSC')
        ->set('class_description', 'Higher Secondary')
        ->call('saveClass')
        ->assertHasNoErrors();

    $academicClass = AcademicClass::query()->first();

    expect($academicClass)->not->toBeNull();

    Livewire::test(ClassIndex::class)
        ->set('subject_academic_class_id', $academicClass->id)
        ->set('subject_name', 'Physics')
        ->set('subject_code', '174')
        ->call('saveSubject')
        ->assertHasNoErrors();

    $subject = Subject::query()->first();

    expect($subject)->not->toBeNull();

    Livewire::test(ClassIndex::class)
        ->set('chapter_subject_id', $subject->id)
        ->set('chapter_name', 'Motion')
        ->set('chapter_no', '1')
        ->call('saveChapter')
        ->assertHasNoErrors();

    $chapter = Chapter::query()->first();

    expect($chapter)->not->toBeNull();

    Livewire::test(ClassIndex::class)
        ->set('topic_chapter_id', $chapter->id)
        ->set('topic_name', 'Velocity')
        ->call('saveTopic')
        ->assertHasNoErrors();

    expect(Topic::query()->where('name', 'Velocity')->exists())->toBeTrue();
});

test('academic structure records can be deleted from the page', function () {
    $academicClass = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'SSC',
        'slug' => 'ssc',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subject = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $academicClass->id,
        'name' => 'Math',
        'subject_code' => '101',
        'slug' => 'math',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $chapter = Chapter::query()->create([
        'uuid' => (string) Str::uuid(),
        'subject_id' => $subject->id,
        'name' => 'Set',
        'chapter_no' => '1',
        'slug' => 'set',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $topic = Topic::query()->create([
        'uuid' => (string) Str::uuid(),
        'chapter_id' => $chapter->id,
        'name' => 'Set Notation',
        'slug' => 'set-notation',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Livewire::test(ClassIndex::class)->call('deleteTopic', $topic->id);
    Livewire::test(ClassIndex::class)->call('deleteChapter', $chapter->id);
    Livewire::test(ClassIndex::class)->call('deleteSubject', $subject->id);
    Livewire::test(ClassIndex::class)->call('deleteClass', $academicClass->id);

    expect(Topic::withTrashed()->find($topic->id)?->deleted_at)->not->toBeNull();
    expect(Chapter::withTrashed()->find($chapter->id)?->deleted_at)->not->toBeNull();
    expect(Subject::withTrashed()->find($subject->id)?->deleted_at)->not->toBeNull();
    expect(AcademicClass::withTrashed()->find($academicClass->id)?->deleted_at)->not->toBeNull();
});

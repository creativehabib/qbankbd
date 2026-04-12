<?php

use App\Livewire\Chapters\ChapterIndex;
use App\Models\AcademicClass;
use App\Models\Subject;
use Illuminate\Support\Str;
use Livewire\Livewire;

it('shows subject name with class name in chapter subject dropdown', function () {
    $classNine = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 9',
        'slug' => 'class-9',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'description' => null,
        'order_sequence' => 2,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classNine->id,
        'name' => 'বাংলা',
        'subject_code' => 'BAN-9',
        'slug' => 'bangla-9',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classTen->id,
        'name' => 'বাংলা',
        'subject_code' => 'BAN-10',
        'slug' => 'bangla-10',
        'description' => null,
        'order_sequence' => 2,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Livewire::test(ChapterIndex::class)
        ->assertSee('বাংলা (Class 9)')
        ->assertSee('বাংলা (Class 10)');
});

it('does not allow creating a chapter with mismatched class and subject', function () {
    $classNine = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 9',
        'slug' => 'class-9',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $classTen = AcademicClass::query()->create([
        'uuid' => (string) Str::uuid(),
        'name' => 'Class 10',
        'slug' => 'class-10',
        'description' => null,
        'order_sequence' => 2,
        'is_active' => true,
        'is_premium' => false,
    ]);

    $subjectForClassNine = Subject::query()->create([
        'uuid' => (string) Str::uuid(),
        'academic_class_id' => $classNine->id,
        'name' => 'বাংলা',
        'subject_code' => 'BAN-9',
        'slug' => 'bangla-9',
        'description' => null,
        'order_sequence' => 1,
        'is_active' => true,
        'is_premium' => false,
    ]);

    Livewire::test(ChapterIndex::class)
        ->set('academic_class_id', (string) $classTen->id)
        ->set('subject_id', (string) $subjectForClassNine->id)
        ->set('name', 'ব্যাকরণ')
        ->call('save')
        ->assertHasErrors(['subject_id']);
});

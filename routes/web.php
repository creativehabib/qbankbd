<?php

use App\Livewire\AcademicClasses\ClassIndex;
use App\Livewire\Chapters\ChapterIndex;
use App\Livewire\ExamCategories\ExamCategoriesIndex;
use App\Livewire\PermissionManager;
use App\Livewire\Questions;
use App\Livewire\Questions\Create;
use App\Livewire\Questions\Edit;
use App\Livewire\RolePermissionManager;
use App\Livewire\Subjects\SubjectIndex;
use App\Livewire\Tags\Index as TagIndex;
use App\Livewire\Teacher\CreateQuestionSet;
use App\Livewire\Teacher\GeneratedQuestionSetPage;
use App\Livewire\Teacher\QuestionGenerator;
use App\Livewire\Teacher\QuestionPaper;
use App\Livewire\Teacher\ViewQuestions;
use App\Livewire\Topics\TopicIndex;
use App\Http\Controllers\DashboardController;
use App\Livewire\Admin\Settings\ThemeOptions;
use App\Livewire\Students\PracticeIndex as StudentPracticeIndex;
use App\Livewire\UserRoleManagement;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    // --- প্রশ্ন ভান্ডার (Question Bank) Routes ---
    Route::get('/questions', Questions::class)->name('questions.index');
    Route::get('/questions/create', Create::class)->name('questions.create');
    Route::get('/questions/{question}/edit', Edit::class)->name('questions.edit');

    Route::middleware('permission:exam_categories.manage')->group(function (): void {
        Route::get('/exam-categories', ExamCategoriesIndex::class)->name('exam-categories.index');
    });

    Route::middleware('permission:academic_classes.manage')->group(function (): void {
        Route::get('/academic-classes', ClassIndex::class)->name('academic-classes.index');
    });

    Route::middleware('permission:subjects.manage')->group(function (): void {
        Route::get('/subjects', SubjectIndex::class)->name('subjects.index');
    });

    Route::middleware('permission:chapters.manage')->group(function (): void {
        Route::get('/chapters', ChapterIndex::class)->name('chapters.index');
    });

    Route::middleware('permission:topics.manage')->group(function (): void {
        Route::get('/topics', TopicIndex::class)->name('topics.index');
    });

    Route::middleware('permission:tags.create|tags.update|tags.delete')->group(function (): void {
        Route::get('/tags', TagIndex::class)->name('tags.index');
    });

    Route::middleware('permission:users.manage_roles')->group(function (): void {
        Route::get('/users', UserRoleManagement::class)->name('users.index');
        Route::get('/admin/theme-options', ThemeOptions::class)->name('admin.theme-options');
    });

    Route::middleware('permission:users.manage_permissions')->group(function (): void {
        Route::get('/permissions', PermissionManager::class)->name('permissions.index');
        Route::get('/roles-permissions', RolePermissionManager::class)->name('roles-permissions.index');
    });

    Route::get('/teacher/question-set-create', CreateQuestionSet::class)->name('questions.set.create');
    Route::get('/teacher/create-question/generated-qset/{qset}', GeneratedQuestionSetPage::class)->name('qset.generated');
    Route::get('/teacher/view-questions', ViewQuestions::class)->name('questions.view');
    Route::get('/teacher/question-create', QuestionGenerator::class)->name('teacher.questions.generate');
    Route::get('/teacher/questions-paper', QuestionPaper::class)->name('questions.paper');

    Route::get('/student/practice', StudentPracticeIndex::class)->name('students.practice.index');
});

require __DIR__.'/settings.php';

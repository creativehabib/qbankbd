<?php

use App\Livewire\AcademicClasses\ClassIndex;
use App\Livewire\Chapters\ChapterIndex;
use App\Livewire\ExamCategories\ExamCategoriesIndex;
use App\Livewire\Questions\QuestionIndex;
use App\Livewire\RolePermissionManager;
use App\Livewire\Subjects\SubjectIndex;
use App\Livewire\Topics\TopicIndex;
use App\Livewire\UserRoleManagement;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // --- প্রশ্ন ভান্ডার (Question Bank) Routes ---

    Route::get('/questions', QuestionIndex::class)->name('questions.index');
    Route::get('/exam-categories', ExamCategoriesIndex::class)->name('exam-categories.index');
    Route::get('/academic-classes', ClassIndex::class)->name('academic-classes.index');
    Route::get('/subjects', SubjectIndex::class)->name('subjects.index');
    Route::get('/chapters', ChapterIndex::class)->name('chapters.index');
    Route::get('/topics', TopicIndex::class)->name('topics.index');

    Route::middleware('permission:users.manage_roles')->group(function (): void {
        Route::get('/user-roles', UserRoleManagement::class)->name('user-roles.index');
    });

    Route::middleware('permission:users.manage_permissions')->group(function (): void {
        Route::get('/roles-permissions', RolePermissionManager::class)->name('roles-permissions.index');
    });
});

require __DIR__.'/settings.php';

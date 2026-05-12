<?php

use App\Http\Controllers\DashboardController;
use App\Livewire\AcademicClasses\ClassIndex;
use App\Livewire\Admin\PackageManagement;
use App\Livewire\Admin\Settings\ThemeOptions;
use App\Livewire\Admin\WalletApprovalPanel;
use App\Livewire\Chapters\ChapterIndex;
use App\Livewire\ExamCategories\ExamCategoriesIndex;
use App\Livewire\OMR\EvaluateOmr;
use App\Livewire\OMR\ManageTokens;
use App\Livewire\OMR\MapAnswers;
use App\Livewire\OmrGenerator;
use App\Livewire\PermissionManager;
use App\Livewire\Questions;
use App\Livewire\Questions\BulkUpload;
use App\Livewire\Questions\Create;
use App\Livewire\Questions\Edit;
use App\Livewire\RolePermissionManager;
use App\Livewire\Students\BookmarkedQuestions;
use App\Livewire\Students\Leaderboard;
use App\Livewire\Students\MistakeReview;
use App\Livewire\Students\MockTestHistory;
use App\Livewire\Students\MockTestResult;
use App\Livewire\OmrScanner;
use App\Livewire\Students\PracticeIndex as StudentPracticeIndex;
use App\Livewire\Students\TakeMockTest;
use App\Livewire\Subjects\SubjectIndex;
use App\Livewire\Tags\Index as TagIndex;
use App\Livewire\Teacher\CreateQuestionSet;
use App\Livewire\Teacher\GeneratedQuestionSetPage;
use App\Livewire\Teacher\InstitutionInfo;
use App\Livewire\Teacher\MyEarnings;
use App\Livewire\Teacher\MyQuestionSets;
use App\Livewire\Teacher\PackageCheckout;
use App\Livewire\Teacher\PricingPlans;
use App\Livewire\Teacher\QuestionGenerator;
use App\Livewire\Teacher\QuestionPaper;
use App\Livewire\Teacher\SubscriptionOverview;
use App\Livewire\Teacher\ViewQuestions;
use App\Livewire\Teacher\WalletTransactions;
use App\Livewire\Topics\TopicIndex;
use App\Livewire\UserRoleManagement;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::patch('/dashboard/question-sets/{questionSet}', [DashboardController::class, 'updateQuestionSet'])->middleware('role:super_admin')->name('dashboard.question-sets.update');
    Route::delete('/dashboard/question-sets/{questionSet}', [DashboardController::class, 'destroyQuestionSet'])->middleware('role:super_admin')->name('dashboard.question-sets.destroy');

    // --- প্রশ্ন ভান্ডার (Question Bank) Routes ---
    Route::get('/questions', Questions::class)->name('questions.index');
    Route::get('/questions/create', Create::class)->name('questions.create');
    Route::get('/questions/bulk-upload', BulkUpload::class)->name('questions.bulk-upload');
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
        Route::get('/admin/wallet-approvals', WalletApprovalPanel::class)->name('admin.wallet-approvals');
        Route::get('/admin/packages', PackageManagement::class)->name('admin.packages');
        Route::get('/admin/theme-options/fonts', function () {
            return Cache::remember('theme-options-fonts', now()->addHours(12), function () {
                $response = Http::timeout(20)->get('https://cdn.jsdelivr.net/gh/hasinhayder/google-fonts/fonts.json');

                if (! $response->successful()) {
                    return [];
                }

                return $response->json();
            });
        })->name('admin.theme-options.fonts');
    });

    Route::middleware('permission:users.manage_permissions')->group(function (): void {
        Route::get('/permissions', PermissionManager::class)->name('permissions.index');
        Route::get('/roles-permissions', RolePermissionManager::class)->name('roles-permissions.index');
    });

    Route::get('/teacher/question-set-create', CreateQuestionSet::class)->name('question.set-create');
    Route::get('/teacher/create-question/generated-qset/{qset}', GeneratedQuestionSetPage::class)->name('qset.generated');
    Route::get('/teacher/view-questions', ViewQuestions::class)->name('questions.view');
    Route::get('/teacher/question-create', QuestionGenerator::class)->name('teacher.questions.generate');
    Route::get('/teacher/my-question-sets', MyQuestionSets::class)->name('teacher.questions.index');
    Route::get('/teacher/questions-paper', QuestionPaper::class)->name('questions.paper');
    Route::get('/teacher/institution-info', InstitutionInfo::class)->middleware('role:teacher')->name('teacher.institution-info');
    Route::get('/teacher/subscription', SubscriptionOverview::class)->middleware('role:teacher')->name('teacher.subscription');
    Route::get('/teacher/pricing', PricingPlans::class)->middleware('role:teacher')->name('teacher.pricing');
    Route::get('/teacher/pricing/checkout/{package}', PackageCheckout::class)->middleware('role:teacher')->name('teacher.pricing.checkout');
    Route::get('/teacher/earnings', MyEarnings::class)->middleware('role:teacher')->name('teacher.earnings');
    Route::get('/teacher/wallet', WalletTransactions::class)->middleware('role:teacher')->name('teacher.wallet');

    Route::get('/student/practice', StudentPracticeIndex::class)->name('students.practice.index');
    Route::get('/student/bookmarks', BookmarkedQuestions::class)->name('student.bookmarks');
    Route::get('/student/mock-test/{testId}', TakeMockTest::class)->name('student.mock-test.take');
    Route::get('/student/mock-test/{testId}/result', MockTestResult::class)->name('student.mock-test.result');
    Route::get('/student/leaderboard', Leaderboard::class)->name('student.leaderboard');
    Route::get('/student/mistakes', MistakeReview::class)->name('student.mistakes');
    Route::get('/student/test-history', MockTestHistory::class)->name('student.test-history');
    Route::get('/student/omr-scanner', OmrScanner::class)->name('student.omr-scanner');

    Route::get('/tokens', ManageTokens::class)->name('tokens.list');
    Route::get('/tokens/{token_id}/map', MapAnswers::class)->name('tokens.map-answers');
    Route::get('/omr/evaluate', EvaluateOmr::class)->name('omr.evaluate');

    Route::middleware('role:teacher|admin|super_admin')->group(function (): void {
        Route::get('/omr-generator', OmrGenerator::class)->name('omr.generator');
    });
});

require __DIR__.'/settings.php';

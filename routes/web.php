<?php

use App\Http\Controllers\BackupDownloadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfGeneratorController;
use App\Livewire\AcademicClasses\ClassIndex;
use App\Livewire\Admin\ModelTests\ModelTestCreate;
use App\Livewire\Admin\ModelTests\ModelTestIndex;
use App\Livewire\Admin\PackageManagement;
use App\Livewire\Admin\Settings\AiSetting;
use App\Livewire\Admin\Settings\BrandingTheme;
use App\Livewire\Admin\Settings\EmailSetting;
use App\Livewire\Admin\Settings\GeneralSetting;
use App\Livewire\Admin\Settings\Index;
use App\Livewire\Admin\Settings\Languages;
use App\Livewire\Admin\Settings\PaymentSetting;
use App\Livewire\Admin\Settings\ThemeOptions;
use App\Livewire\Admin\Settings\WebsiteTracking;
use App\Livewire\Admin\WalletApprovalPanel;
use App\Livewire\Chapters\ChapterIndex;
use App\Livewire\ExamCategories\ExamCategoriesIndex;
use App\Livewire\OMR\EvaluateOmr;
use App\Livewire\OMR\ManageTokens;
use App\Livewire\OMR\MapAnswers;
use App\Livewire\OmrGenerator;
use App\Livewire\OmrScanner;
use App\Livewire\PermissionManager;
use App\Livewire\Questions;
use App\Livewire\Questions\BulkUpload;
use App\Livewire\Questions\Create;
use App\Livewire\Questions\Edit;
use App\Livewire\RolePermissionManager;
use App\Livewire\Students\BookmarkedQuestions;
use App\Livewire\Students\CheckoutPage;
use App\Livewire\Students\GoalSelection;
use App\Livewire\Students\Leaderboard;
use App\Livewire\Students\MistakeReview;
use App\Livewire\Students\MockTestHistory;
use App\Livewire\Students\MockTestResult;
use App\Livewire\Students\ModelTests\ModelTestAttempt;
use App\Livewire\Students\ModelTests\ModelTestResultPage;
use App\Livewire\Students\PerformanceAnalytics;
use App\Livewire\Students\PracticeIndex as StudentPracticeIndex;
use App\Livewire\Students\PricingPage;
use App\Livewire\Students\TakeMockTest;
use App\Livewire\Subjects\SubjectIndex;
use App\Livewire\SuperAdmin\Settings\ActivityLogs;
use App\Livewire\SuperAdmin\Settings\Backups;
use App\Livewire\SuperAdmin\Settings\CacheManagement;
use App\Livewire\SuperAdmin\Settings\Htaccess;
use App\Livewire\SuperAdmin\Settings\SitemapSetting;
use App\Livewire\SuperAdmin\Settings\SystemInformation;
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
    //    Route::get('/questions/{question}/show', App\Livewire\ShowQuestion::class)->name('questions.show');
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

    Route::middleware('role:admin|super_admin')->group(function (): void {
        // Model Tests (Admin created Mock Tests)
        Route::get('/admin/model-tests', ModelTestIndex::class)->name('admin.model-tests.index');
        Route::get('/admin/model-tests/create', ModelTestCreate::class)->name('admin.model-tests.create');

        // Admin Settings
        Route::get('/admin/settings', Index::class)->name('admin.settings.index');
        Route::get('/admin/settings/general', GeneralSetting::class)->name('admin.settings.general');
        Route::get('/admin/settings/branding-theme', BrandingTheme::class)->name('admin.settings.branding');
        Route::get('/admin/settings/email', EmailSetting::class)->name('admin.settings.email');
        Route::get('/admin/settings/ai', AiSetting::class)->name('admin.settings.ai');
        Route::get('/admin/settings/languages', Languages::class)->name('admin.settings.languages');
        Route::get('/admin/settings/tracking', WebsiteTracking::class)->name('admin.settings.tracking');
        Route::get('/admin/settings/payment', PaymentSetting::class)->name('admin.settings.payment');

        // Super Admin Settings
        Route::get('/superadmin/settings/sitemap', SitemapSetting::class)->middleware('role:super_admin')->name('superadmin.settings.sitemap');
        Route::get('/superadmin/settings/htaccess', Htaccess::class)->middleware('role:super_admin')->name('superadmin.settings.htaccess');
        Route::get('/superadmin/settings/backups', Backups::class)->middleware('role:super_admin')->name('superadmin.settings.backups');
        Route::get('/superadmin/settings/backups/download', [BackupDownloadController::class, 'download'])->middleware('role:super_admin')->name('superadmin.settings.backups.download');
        Route::get('/superadmin/settings/cache', CacheManagement::class)->middleware('role:super_admin')->name('superadmin.settings.cache');
        Route::get('/superadmin/settings/system-info', SystemInformation::class)->middleware('role:super_admin')->name('superadmin.settings.system-info');
        Route::get('/superadmin/settings/activity-logs', ActivityLogs::class)->middleware('role:super_admin')->name('superadmin.settings.activity-logs');
    });

    Route::middleware('permission:users.manage_permissions')->group(function (): void {
        Route::get('/permissions', PermissionManager::class)->name('permissions.index');
        Route::get('/roles-permissions', RolePermissionManager::class)->name('roles-permissions.index');
    });

    Route::get('/question-set/{id}/download-pdf', [PdfGeneratorController::class, 'downloadQuestionPaper'])
        ->name('pdf.download')
        ->middleware('auth');

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

    Route::get('/student/goals', GoalSelection::class)->name('student.goals');
    Route::get('/student/practice', StudentPracticeIndex::class)->name('students.practice.index');
    Route::get('/student/bookmarks', BookmarkedQuestions::class)->name('student.bookmarks');
    Route::get('/student/mock-test/{testId}', TakeMockTest::class)->name('student.mock-test.take');
    Route::get('/student/mock-test/{testId}/result', MockTestResult::class)->name('student.mock-test.result');

    // New Model Tests (Admin Created)
    Route::get('/student/model-tests', App\Livewire\Students\ModelTests\ModelTestIndex::class)->name('student.model-tests.index');
    Route::get('/student/model-tests/{modelTest}', ModelTestAttempt::class)->name('student.model-tests.attempt');
    Route::get('/student/model-tests/result/{resultId}', ModelTestResultPage::class)->name('student.model-tests.result');
    Route::get('/student/leaderboard', Leaderboard::class)->name('student.leaderboard');
    Route::get('/student/mistakes', MistakeReview::class)->name('student.mistakes');
    Route::get('/student/test-history', MockTestHistory::class)->name('student.test-history');
    Route::get('/student/analytics', PerformanceAnalytics::class)->name('student.analytics');
    Route::get('/student/pricing', PricingPage::class)->name('student.pricing');
    Route::get('/student/checkout/{package_id}', CheckoutPage::class)->name('student.checkout');
    Route::get('/student/omr-scanner', OmrScanner::class)->name('student.omr-scanner');

    Route::get('/tokens', ManageTokens::class)->name('tokens.list');
    Route::get('/tokens/{token_id}/map', MapAnswers::class)->name('tokens.map-answers');
    Route::get('/omr/evaluate', EvaluateOmr::class)->name('omr.evaluate');

    Route::middleware('role:teacher|admin|super_admin')->group(function (): void {
        Route::get('/omr-generator', OmrGenerator::class)->name('omr.generator');
    });
});

// Payment Initiation Routes (Must be logged in)
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/bkash/pay/{package}', [PaymentController::class, 'bkashPay'])->name('payment.bkash.pay');
    Route::post('/payment/ssl/pay/{package}', [PaymentController::class, 'sslPay'])->name('payment.ssl.pay');
});

// Payment Callback Routes (Session might be dropped by browser due to cross-site POST)
Route::get('/payment/bkash/callback', [PaymentController::class, 'bkashCallback'])->name('payment.bkash.callback');
Route::post('/payment/ssl/success', [PaymentController::class, 'sslSuccess'])->name('payment.ssl.success');
Route::post('/payment/ssl/fail', [PaymentController::class, 'sslFail'])->name('payment.ssl.fail');
Route::post('/payment/ssl/cancel', [PaymentController::class, 'sslCancel'])->name('payment.ssl.cancel');
// SSL IPN is usually not authenticated
Route::post('/payment/ssl/ipn', [PaymentController::class, 'sslIpn'])->name('payment.ssl.ipn');

// Nagad Payment Routes
Route::post('/payment/nagad/pay/{package}', [PaymentController::class, 'nagadPay'])->name('payment.nagad.pay');
Route::get('/payment/nagad/callback', [PaymentController::class, 'nagadCallback'])->name('payment.nagad.callback');

require __DIR__.'/settings.php';

<?php

namespace App\Http\Controllers;

use App\Models\QuestionSet;
use App\Models\Question;
use App\Models\User;
use App\Models\ExamCategory;
use App\Models\AcademicClass;
use App\Models\MockTest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isSuperAdmin()) {
            $questionSets = QuestionSet::query()
                ->with('user:id,name')
                ->latest()
                ->get();

            $summary = $questionSets
                ->groupBy('user_id')
                ->map(function ($sets) {
                    $typedCounts = $sets->groupBy(fn (QuestionSet $set) => $set->generation_criteria['type'] ?? 'unknown')
                        ->map(fn ($typedSets) => $typedSets->count());

                    return [
                        'user_name' => $sets->first()?->user?->name ?? 'Unknown User',
                        'question_set_count' => $sets->count(),
                        'question_total' => $sets->sum(fn (QuestionSet $set) => (int) ($set->generation_criteria['quantity'] ?? 0)),
                        'types' => $typedCounts,
                    ];
                })
                ->sortByDesc('question_set_count')
                ->values();

            $overviewStats = [
                'total_questions' => Question::query()->count(),
                'total_users' => User::query()->count(),
                'total_exam_categories' => ExamCategory::query()->count(),
                'monthly_revenue' => 0,
                'pending_approval' => Question::query()->where('status', 'pending')->count(),
            ];

            return view('dashboards.super-admin', [
                'questionSets' => $questionSets,
                'creatorSummary' => $summary,
                'overviewStats' => $overviewStats,
            ]);
        }

        if ($user->isAdmin()) {
            return view('dashboards.admin');
        }

        if ($user->isTeacher()) {
            $teacherQuestionSets = QuestionSet::query()
                ->where('user_id', $user->id)
                ->latest()
                ->get();

            $totalQuestionSets = $teacherQuestionSets->count();
            $totalMcqQuestions = $teacherQuestionSets
                ->where(fn (QuestionSet $set) => ($set->generation_criteria['type'] ?? null) === 'mcq')
                ->sum(fn (QuestionSet $set) => (int) ($set->generation_criteria['quantity'] ?? 0));
            $totalWrittenQuestions = $teacherQuestionSets
                ->where(fn (QuestionSet $set) => in_array(($set->generation_criteria['type'] ?? null), ['cq', 'written'], true))
                ->sum(fn (QuestionSet $set) => (int) ($set->generation_criteria['quantity'] ?? 0));

            $academicClasses = AcademicClass::query()
                ->with(['subjects' => fn ($query) => $query->orderBy('name')])
                ->orderBy('name')
                ->get(['id', 'name']);

            return view('dashboards.teacher', [
                'teacherStats' => [
                    'total_question_sets' => $totalQuestionSets,
                    'total_mcq_questions' => $totalMcqQuestions,
                    'total_written_questions' => $totalWrittenQuestions,
                    'total_cost' => 0,
                ],
                'recentQuestionSet' => $teacherQuestionSets->first(),
                'academicClasses' => $academicClasses,
            ]);
        }

        // ==========================================
        // Student Dashboard Logic (Updated)
        // ==========================================
        $userId = $user->id;

        // URL থেকে রেঞ্জ নেওয়া, না থাকলে ডিফল্ট ৭ দিন
        $range = (int) $request->get('range', 7);
        if (!in_array($range, [7, 15, 30])) {
            $range = 7;
        }

        $startDate = now()->subDays($range - 1)->startOfDay();

        $lastDaysTests = MockTest::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();

        $examTakenCount = $lastDaysTests->count();
        $totalStudyMinutes = 0;
        $totalRight = 0;
        $totalWrong = 0;
        $totalSkipped = 0;

        $engagementCategories = [];
        $engagementMap = [];

        for ($i = $range - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            $engagementCategories[] = $date->format('d M');
            $engagementMap[$dateKey] = 0;
        }

        foreach ($lastDaysTests as $test) {
            $start = Carbon::parse($test->started_at);
            $end = $test->completed_at ? Carbon::parse($test->completed_at) : $start->copy()->addMinutes($test->duration_minutes ?? 20);

            $actualMinutesTaken = $start->diffInMinutes($end);
            $allocatedMinutes = $test->duration_minutes ?? 20;

            // স্মার্ট স্টাডি টাইম ক্যালকুলেশন
            $totalStudyMinutes += ($actualMinutesTaken > $allocatedMinutes) ? $allocatedMinutes : $actualMinutesTaken;

            $totalRight += (int) $test->correct_answers;
            $totalWrong += (int) $test->wrong_answers;
            $skipped = (int) $test->total_questions - ((int) $test->correct_answers + (int) $test->wrong_answers);
            $totalSkipped += ($skipped > 0 ? $skipped : 0);

            $dateKey = $start->format('Y-m-d');
            if (isset($engagementMap[$dateKey])) {
                $engagementMap[$dateKey] += 1;
            }
        }

        $engagementValues = array_values($engagementMap);

        $hours = floor($totalStudyMinutes / 60);
        $minutes = $totalStudyMinutes % 60;
        $studyTimeFormatted = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

        // নতুন একিউরেসি সূত্র (Skipped সহ হিসাব)
        $totalQuestionsCount = $totalRight + $totalWrong + $totalSkipped;
        $accuracyPercentage = $totalQuestionsCount > 0 ? round(($totalRight / $totalQuestionsCount) * 100, 1) : 0;

        // Rank & Streak
        $myTotalScore = MockTest::where('user_id', $userId)->sum('correct_answers');
        $betterUsersCount = User::whereHas('mockTests')
            ->withSum('mockTests as total_score', 'correct_answers')
            ->having('total_score', '>', $myTotalScore)
            ->count();

        $myDynamicRank = $betterUsersCount + 1;
        $lastTest = MockTest::where('user_id', $userId)->latest('created_at')->first();
        $streakDays = ($lastTest && $lastTest->created_at->isToday()) ? 1 : 0;

        $studentStats = [
            'streak_days' => $streakDays,
            'rank' => $myDynamicRank,
            'study_time' => $studyTimeFormatted,
            'exam_taken' => $examTakenCount,
            'accuracy' => [
                'percentage' => $accuracyPercentage,
                'right' => $totalRight,
                'wrong' => $totalWrong,
                'skipped' => $totalSkipped,
            ],
            'engagement' => [
                'categories' => $engagementCategories,
                'data' => $engagementValues
            ]
        ];

        $leaderboard = User::query()
            ->whereHas('roles', function($q) {
                $q->where('name', 'student'); // শুধুমাত্র স্টুডেন্টদের আনবে
            })
            ->where('xp', '>', 0)
            ->orderByDesc('xp')
            ->take(5)
            ->get(['id', 'name', 'xp']);

        $attendedExams = MockTest::with('subject:id,name')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(5)
            ->get()
            ->map(function($test) {
                $start = Carbon::parse($test->started_at);
                $end = $test->completed_at ? Carbon::parse($test->completed_at) : now();
                $skipped = $test->total_questions - ($test->correct_answers + $test->wrong_answers);
                return [
                    'id' => $test->id,
                    'name' => $test->subject ? $test->subject->name . ' এর মক টেস্ট' : 'সাধারণ মক টেস্ট',
                    'score' => $test->total_score,
                    'total' => $test->total_questions,
                    'time' => $start->diffInMinutes($end) . ' Mins',
                    'right' => $test->correct_answers,
                    'wrong' => $test->wrong_answers,
                    'skipped' => $skipped > 0 ? $skipped : 0,
                    'date' => $test->created_at->diffForHumans()
                ];
            });

        return view('dashboards.student', [
            'studentStats' => $studentStats,
            'leaderboard' => $leaderboard,
            'attendedExams' => $attendedExams,
            'range' => $range
        ]);
    }

    public function updateQuestionSet(Request $request, QuestionSet $questionSet): RedirectResponse
    {
        abort_unless((bool) $request->user()?->isSuperAdmin(), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:mcq,cq,combine,short,written',
            'quantity' => 'required|integer|min:1|max:500',
        ]);

        $criteria = $questionSet->generation_criteria ?? [];
        $criteria['type'] = $validated['type'];
        $criteria['quantity'] = $validated['quantity'];

        $questionSet->update([
            'name' => $validated['name'],
            'generation_criteria' => $criteria,
        ]);

        return back()->with('success', 'প্রশ্ন সেট আপডেট করা হয়েছে।');
    }

    public function destroyQuestionSet(Request $request, QuestionSet $questionSet): RedirectResponse
    {
        abort_unless((bool) $request->user()?->isSuperAdmin(), 403);
        $questionSet->delete();
        return back()->with('success', 'প্রশ্ন সেট ডিলিট করা হয়েছে।');
    }
}

<?php
$content = file_get_contents('app/Http/Controllers/DashboardController.php');
$startMarker = '// ৪. Student Dashboard Logic';
$endMarker = "return view('dashboards.student', [";

$posStart = strpos($content, $startMarker);
$posEnd = strpos($content, $endMarker);

if ($posStart === false || $posEnd === false) {
    echo "Markers not found.\n";
    exit(1);
}

$newLogic = <<<'LOGIC'
// ৪. Student Dashboard Logic
        // ==========================================
        $userId = $user->id;
        $range = (int) $request->get('range', 7);
        if (!in_array($range, [7, 15, 30])) {
            $range = 7;
        }

        $startDate = now()->subDays($range - 1)->startOfDay();

        $lastDaysTests = MockTest::where('user_id', $userId)
            ->where('status', 'completed')
            ->where('created_at', '>=', $startDate)
            ->get();
            
        $lastDaysModelTests = \App\Models\ModelTestResult::with('modelTest')
            ->where('user_id', $userId)
            ->where('created_at', '>=', $startDate)
            ->get();

        $examTakenCount = $lastDaysTests->count() + $lastDaysModelTests->count();
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
            $start = \Carbon\Carbon::parse($test->started_at);
            $end = $test->completed_at ? \Carbon\Carbon::parse($test->completed_at) : $start->copy()->addMinutes($test->duration_minutes ?? 20);

            $actualMinutesTaken = $start->diffInMinutes($end);
            $allocatedMinutes = $test->duration_minutes ?? 20;

            $totalStudyMinutes += ($actualMinutesTaken > $allocatedMinutes) ? $allocatedMinutes : $actualMinutesTaken;

            $totalRight += (int) $test->correct_answers;
            $totalWrong += (int) $test->wrong_answers;
            $skipped = $test->total_questions - ($test->correct_answers + $test->wrong_answers);
            $totalSkipped += ($skipped > 0 ? $skipped : 0);

            $dateKey = $start->format('Y-m-d');
            if (isset($engagementMap[$dateKey])) {
                $engagementMap[$dateKey] += 1;
            }
        }
        
        foreach ($lastDaysModelTests as $test) {
            $totalStudyMinutes += ceil(($test->time_taken_seconds ?? 0) / 60);

            $totalRight += (int) $test->correct_count;
            $totalWrong += (int) $test->wrong_count;
            $totalSkipped += (int) $test->unanswered_count;

            $dateKey = $test->created_at->format('Y-m-d');
            if (isset($engagementMap[$dateKey])) {
                $engagementMap[$dateKey] += 1;
            }
        }

        $engagementValues = array_values($engagementMap);

        $hours = floor($totalStudyMinutes / 60);
        $minutes = $totalStudyMinutes % 60;
        $studyTimeFormatted = $hours > 0 ? "{$hours}h {$minutes}m" : "{$minutes}m";

        $totalQuestionsCount = $totalRight + $totalWrong + $totalSkipped;
        $accuracyPercentage = $totalQuestionsCount > 0 ? round(($totalRight / $totalQuestionsCount) * 100, 1) : 0;

        $myDynamicRank = User::where('xp', '>', $user->xp)->count() + 1;
        
        $lastTest = MockTest::where('user_id', $userId)->latest('created_at')->first();
        $lastModelTest = \App\Models\ModelTestResult::where('user_id', $userId)->latest('created_at')->first();
        
        $lastActivityDate = null;
        if ($lastTest && $lastModelTest) {
            $lastActivityDate = $lastTest->created_at->gt($lastModelTest->created_at) ? $lastTest->created_at : $lastModelTest->created_at;
        } elseif ($lastTest) {
            $lastActivityDate = $lastTest->created_at;
        } elseif ($lastModelTest) {
            $lastActivityDate = $lastModelTest->created_at;
        }
        
        $streakDays = ($lastActivityDate && $lastActivityDate->isToday()) ? 1 : 0;

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
                $q->where('name', 'student');
            })
            ->where('xp', '>', 0)
            ->orderByDesc('xp')
            ->take(5)
            ->get(['id', 'name', 'xp']);

        $mockExamsList = MockTest::with('subject:id,name')
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(5)
            ->get()
            ->map(function($test) {
                $start = \Carbon\Carbon::parse($test->started_at);
                $end = $test->completed_at ? \Carbon\Carbon::parse($test->completed_at) : now();
                $skipped = $test->total_questions - ($test->correct_answers + $test->wrong_answers);
                return [
                    'id' => 'mock_'.$test->id,
                    'name' => $test->subject ? $test->subject->name . ' এর মক টেস্ট' : 'সাধারণ মক টেস্ট',
                    'score' => $test->total_score,
                    'total' => $test->total_questions,
                    'time' => $start->diffInMinutes($end) . ' Mins',
                    'right' => $test->correct_answers,
                    'wrong' => $test->wrong_answers,
                    'skipped' => $skipped > 0 ? $skipped : 0,
                    'date' => $test->created_at,
                    'date_human' => $test->created_at->diffForHumans()
                ];
            });
            
        $modelExamsList = \App\Models\ModelTestResult::with('modelTest')
            ->where('user_id', $userId)
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function($test) {
                $timeMins = ceil(($test->time_taken_seconds ?? 0) / 60);
                $total = $test->correct_count + $test->wrong_count + $test->unanswered_count;
                return [
                    'id' => 'model_'.$test->id,
                    'name' => ($test->modelTest->title ?? 'মডেল টেস্ট'),
                    'score' => $test->total_score,
                    'total' => $total,
                    'time' => $timeMins . ' Mins',
                    'right' => $test->correct_count,
                    'wrong' => $test->wrong_count,
                    'skipped' => $test->unanswered_count,
                    'date' => $test->created_at,
                    'date_human' => $test->created_at->diffForHumans()
                ];
            });
            
        $attendedExams = $mockExamsList->concat($modelExamsList)
            ->sortByDesc('date')
            ->take(5)
            ->values();

        
LOGIC;

$newContent = substr($content, 0, $posStart) . $newLogic . substr($content, $posEnd);
file_put_contents('app/Http/Controllers/DashboardController.php', $newContent);
echo "Dashboard updated.\n";

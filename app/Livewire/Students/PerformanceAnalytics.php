<?php

namespace App\Livewire\Students;

use App\Models\ModelTestUserAnswer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PerformanceAnalytics extends Component
{
    public function render()
    {
        $userId = auth()->id();

        // Calculate Subject-wise Performance
        $subjectStats = ModelTestUserAnswer::query()
            ->join('subjects', 'model_test_user_answers.subject_id', '=', 'subjects.id')
            ->join('model_test_results', 'model_test_user_answers.model_test_result_id', '=', 'model_test_results.id')
            ->where('model_test_results.user_id', $userId)
            ->select(
                'subjects.name',
                DB::raw('COUNT(*) as total_attempted'),
                DB::raw('SUM(is_correct = 1) as correct_answers'),
                DB::raw('ROUND((SUM(is_correct = 1) / COUNT(*)) * 100) as accuracy')
            )
            ->groupBy('subjects.id', 'subjects.name')
            ->having('total_attempted', '>', 0)
            ->orderByDesc('accuracy')
            ->get();

        // Get Top 3 Weak Subjects
        $weakSubjects = $subjectStats->sortBy('accuracy')->take(3);
        
        // Get Top 3 Strong Subjects
        $strongSubjects = $subjectStats->sortByDesc('accuracy')->take(3);

        return view('livewire.students.performance-analytics', [
            'subjectStats' => $subjectStats,
            'weakSubjects' => $weakSubjects,
            'strongSubjects' => $strongSubjects,
        ])->layout('layouts.app', ['title' => 'My Performance Analytics']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\QuestionSet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(): View|RedirectResponse
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

            return view('dashboards.super-admin', [
                'questionSets' => $questionSets,
                'creatorSummary' => $summary,
            ]);
        }

        if ($user->isAdmin()) {
            return view('dashboards.admin');
        }

        if ($user->isTeacher()) {
            return view('dashboards.teacher');
        }

        return view('dashboards.student');
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

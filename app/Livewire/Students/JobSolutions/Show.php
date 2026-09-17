<?php

namespace App\Livewire\Students\JobSolutions;

use App\Models\PastExam;
use App\Models\Institution;
use App\Models\Question;
use App\Services\AiService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Show extends Component
{
    public $exam;
    public $institution;
    
    
    // UI toggles
    
    
    
    

    public int $perPage = 20;
    public $activeSubjectId = null;

    public function setSubject($id = null): void
    {
        $this->activeSubjectId = $id;
        $this->perPage = 20; // reset pagination when switching tabs
    }

    public function loadMore(): void
    {
        $this->perPage += 20;
    }

    public function mount($institutionSlug, $examSlug)
    {
        $this->institution = Institution::where('slug', $institutionSlug)->firstOrFail();
        
        $this->exam = PastExam::where('slug', $examSlug)
            ->where('institution_id', $this->institution->id)
            ->with([
                'institution', 
                'questions' => function($q) {
                    if (auth()->check()) {
                        $q->withExists([
                            'bookmarks as is_bookmarked' => fn ($q) => $q->where('user_id', auth()->id()),
                            'likes as is_liked' => fn ($q) => $q->where('user_id', auth()->id())
                        ]);
                    }
                },
                'questions.subject', 
                'questions.chapter', 
                'questions.topic'
            ])
            ->firstOrFail();
    }

    public $aiError = null;

    public function toggleBookmark(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->bookmarks()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('bookmarks_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('bookmarks_count');
        }
    }

    public function toggleLike(int $questionId): void
    {
        $question = Question::findOrFail($questionId);
        $toggled = $question->likes()->toggle(auth()->id());

        if (count($toggled['attached']) > 0) {
            $question->increment('likes_count');
        } elseif (count($toggled['detached']) > 0) {
            $question->decrement('likes_count');
        }
    }


    public function generateAiExplanation($questionId): void
    {
        $this->aiError = null;
        session()->flash('last_question_id', $questionId);

        try {
            $question = Question::findOrFail($questionId);
            $geminiService = new AiService;
            $geminiService->generateAndSaveExplanation($question);
        } catch (\Exception $e) {
            $this->aiError = $e->getMessage();
        }
    }

    public function render()
    {
        $questions = $this->exam->questions;
        $totalQuestions = $questions->count();
        
        // Build subjects array with question counts
        $subjectsData = collect();
        $questionsBySubject = $questions->groupBy('subject_id');
        
        foreach ($questionsBySubject as $subjectId => $qs) {
            $subject = $qs->first()->subject;
            if ($subject) {
                $subjectsData->push([
                    'id' => $subject->id,
                    'name' => $subject->name,
                    'count' => $qs->count()
                ]);
            }
        }
        
        // Sort subjects by count descending
        $subjectsData = $subjectsData->sortByDesc('count')->values();

        // Filter by subject if one is selected, then paginate
        if ($this->activeSubjectId) {
            $filteredQuestions = $questions->where('subject_id', $this->activeSubjectId);
        } else {
            $filteredQuestions = $questions;
        }
        $activeQuestions = $filteredQuestions->take($this->perPage);

        // Calculate Topic Weightage for ALL questions (Independent of active subject)
        $topicWeightage = collect();
        if ($totalQuestions > 0) {
            foreach ($questionsBySubject as $subjectId => $subjectQuestions) {
                $subject = $subjectQuestions->first()->subject;
                $subjectName = $subject ? $subject->name : 'বিবিধ';
                $subjectCount = $subjectQuestions->count();
                $subjectPercentage = round(($subjectCount / $totalQuestions) * 100, 1);
                
                // Group by chapters
                $chaptersData = collect();
                $questionsByChapter = $subjectQuestions->groupBy('chapter_id');
                
                foreach ($questionsByChapter as $chapterId => $chapterQuestions) {
                    $chapter = $chapterQuestions->first()->chapter;
                    $chapterName = $chapter ? $chapter->name : 'অন্যান্য টপিক';
                    $chapterCount = $chapterQuestions->count();
                    $chapterPercentage = round(($chapterCount / $totalQuestions) * 100, 1);
                    
                    $chaptersData->push([
                        'name' => $chapterName,
                        'count' => $chapterCount,
                        'percentage' => $chapterPercentage
                    ]);
                }
                
                // Sort chapters by count descending
                $chaptersData = $chaptersData->sortByDesc('count')->values();
                
                $topicWeightage->push([
                    'name' => $subjectName,
                    'count' => $subjectCount,
                    'percentage' => $subjectPercentage,
                    'chapters' => $chaptersData
                ]);
            }
            
            // Sort subjects by count descending
            $topicWeightage = $topicWeightage->sortByDesc('count')->values();
        }

        // Fetch other top institutions (excluding current one)
        $otherInstitutions = Institution::where('id', '!=', $this->institution->id)
            ->withCount('pastExams')
            ->having('past_exams_count', '>', 0)
            ->orderBy('past_exams_count', 'desc')
            ->take(5)
            ->get();

        return view('livewire.students.job-solutions.show', [
            'subjectsData' => $subjectsData,
            'activeQuestions' => $activeQuestions,
            'topicWeightage' => $topicWeightage,
            'totalQuestions' => $totalQuestions,
            'otherInstitutions' => $otherInstitutions
        ])->layout('layouts.frontend', ['title' => $this->exam->title]);
    }
}


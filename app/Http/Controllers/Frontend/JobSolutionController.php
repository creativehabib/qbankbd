<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\PastExam;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Question;
use Illuminate\Http\Request;

class JobSolutionController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'exams');
        
        $subjectSlug = $request->get('subject');
        $topicSlug = $request->get('topic');
        $subTopicSlug = $request->get('sub_topic');

        $data = ['tab' => $tab];

        if ($tab === 'exams') {
            $data['exams'] = PastExam::with('institution', 'examCategory')
                ->withCount('questions')
                ->latest('exam_date')
                ->paginate(15)->withQueryString();
        } elseif ($tab === 'topics') {
            // Load Subjects
            $data['subjects'] = Subject::withCount(['questions' => function($q) {
                $q->has('pastExams');
            }])->having('questions_count', '>', 0)->orderBy('name')->get();

            $currentSubjectObj = $subjectSlug ? Subject::where('slug', $subjectSlug)->first() : null;
            $currentChapterObj = $topicSlug ? Chapter::where('slug', $topicSlug)->first() : null;
            $currentTopicObj = $subTopicSlug ? Topic::where('slug', $subTopicSlug)->first() : null;

            // Load Chapters
            $data['chapters'] = [];
            if ($currentSubjectObj) {
                $data['chapters'] = Chapter::where('subject_id', $currentSubjectObj->id)
                    ->withCount(['questions' => function($q) {
                        $q->has('pastExams');
                    }])->having('questions_count', '>', 0)->orderBy('name')->get();
            }

            // Load Topics
            $data['topics'] = [];
            if ($currentChapterObj) {
                $data['topics'] = Topic::where('chapter_id', $currentChapterObj->id)
                    ->withCount(['questions' => function($q) {
                        $q->has('pastExams');
                    }])->having('questions_count', '>', 0)->orderBy('name')->get();
            }

            // Load Questions
            $query = Question::query()->has('pastExams');
            
            if ($currentTopicObj) {
                $query->where('topic_id', $currentTopicObj->id);
            } elseif ($currentChapterObj) {
                $query->where('chapter_id', $currentChapterObj->id);
            } elseif ($currentSubjectObj) {
                $query->where('subject_id', $currentSubjectObj->id);
            }

            $data['questions'] = $query->paginate(15)->withQueryString();
            $data['total_questions'] = $data['questions']->total();
            
            $data['currentSubject'] = $currentSubjectObj;
            $data['currentChapter'] = $currentChapterObj;
            $data['currentTopic'] = $currentTopicObj;
            
            // Pass the active slugs
            $data['subject'] = $subjectSlug;
            $data['topic'] = $topicSlug;
            $data['sub_topic'] = $subTopicSlug;
        } elseif ($tab === 'organizations') {
            $data['institutions'] = Institution::withCount('pastExams')
                ->orderBy('name')
                ->paginate(24)->withQueryString();
        }

        return view('frontend.job-solutions.index', $data);
    }

    public function institutionShow(Request $request, $institutionSlug)
    {
        $institution = Institution::where('slug', $institutionSlug)->firstOrFail();

        $search = $request->get('search');
        $categoryId = $request->get('category');
        $year = $request->get('year'); $type = $request->get('type', 'all');

        $query = PastExam::where('institution_id', $institution->id)
            ->with('examCategory')
            ->withCount('questions');

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
        if ($categoryId) {
            $query->where('exam_category_id', $categoryId);
        }
                if ($year) {
            $query->whereYear('exam_date', $year);
        }


        $exams = $query->orderBy('exam_date', 'desc')->get();

        $categories = \App\Models\ExamCategory::all();
        $years = PastExam::where('institution_id', $institution->id)
            ->selectRaw('YEAR(exam_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('frontend.job-solutions.institution-show', compact('institution', 'exams', 'categories', 'years', 'search', 'categoryId', 'year', 'type'));
    }

    public function show($institutionSlug, $examSlug)
    {
        $institution = Institution::where('slug', $institutionSlug)->firstOrFail();
        
        $exam = PastExam::where('slug', $examSlug)
            ->where('institution_id', $institution->id)
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

        $questions = $exam->questions;
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
        
        $subjectsData = $subjectsData->sortByDesc('count')->values();
        
        // Here we send all questions to the view. Alpine will filter them.
        $activeQuestions = $questions;

        // Calculate Topic Weightage
        $topicWeightage = collect();
        if ($totalQuestions > 0) {
            foreach ($questionsBySubject as $subjectId => $subjectQuestions) {
                $subject = $subjectQuestions->first()->subject;
                $subjectName = $subject ? $subject->name : 'বিবিধ';
                $subjectCount = $subjectQuestions->count();
                $subjectPercentage = round(($subjectCount / $totalQuestions) * 100, 1);
                
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
                
                $chaptersData = $chaptersData->sortByDesc('count')->values();
                
                $topicWeightage->push([
                    'name' => $subjectName,
                    'count' => $subjectCount,
                    'percentage' => $subjectPercentage,
                    'chapters' => $chaptersData
                ]);
            }
            
            $topicWeightage = $topicWeightage->sortByDesc('count')->values();
        }

        // Fetch other top institutions (excluding current one)
        $otherInstitutions = Institution::where('id', '!=', $institution->id)
            ->withCount('pastExams')
            ->having('past_exams_count', '>', 0)
            ->orderBy('past_exams_count', 'desc')
            ->take(5)
            ->get();

        return view('frontend.job-solutions.show', compact(
            'exam', 'institution', 'subjectsData', 'activeQuestions', 'topicWeightage', 'totalQuestions', 'otherInstitutions'
        ));
    }
    
        public function questionShow($slug)
    {
        $question = Question::where('slug', $slug)
            ->with(['subject', 'chapter', 'topic', 'pastExams'])
            ->firstOrFail();
            
        // Increment views safely with cache protection
        $viewerId = auth()->check() ? 'user_'.auth()->id() : 'ip_'.request()->ip();
        $cacheKey = "viewed_question_{$question->id}_by_{$viewerId}";

        if (! \Illuminate\Support\Facades\Cache::has($cacheKey)) {
            $question->increment('views_count');
            \Illuminate\Support\Facades\Cache::put($cacheKey, true, now()->addHours(24));
        }

        // Get chapter stats for sidebar
        $chapterStats = [];
        if ($question->subject_id) {
            $chapterStats = \App\Models\Chapter::where('subject_id', $question->subject_id)
                ->withCount('questions')
                ->get();
        }

        // Get related questions
        $relatedQuestions = Question::where('id', '!=', $question->id)
            ->where(function ($query) use ($question) {
                if ($question->topic_id) {
                    $query->where('topic_id', $question->topic_id);
                } elseif ($question->chapter_id) {
                    $query->where('chapter_id', $question->chapter_id);
                } else {
                    $query->where('subject_id', $question->subject_id);
                }
            })
            ->limit(5)
            ->get();

        // Get Prev and Next questions
        $prevQuestion = Question::where('id', '<', $question->id)
            ->orderBy('id', 'desc')
            ->first();
            
        $nextQuestion = Question::where('id', '>', $question->id)
            ->orderBy('id', 'asc')
            ->first();

        if (auth()->check()) {
            $question->loadExists([
                'bookmarks as is_bookmarked' => fn ($q) => $q->where('user_id', auth()->id()),
                'likes as is_liked' => fn ($q) => $q->where('user_id', auth()->id())
            ]);
        }

        return view('frontend.question-show', compact('question', 'relatedQuestions', 'chapterStats', 'prevQuestion', 'nextQuestion'));
    }
}

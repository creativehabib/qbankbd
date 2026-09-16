<?php

namespace App\Livewire\Students\JobSolutions;

use App\Models\Institution;
use App\Models\PastExam;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Topic;
use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $tab = 'exams'; // exams, topics, organizations
    
    // Slugs from query string
    public $subject = null;
    public $topic = null;
    public $sub_topic = null;

    protected $queryString = [
        'tab' => ['except' => 'exams'],
        'subject' => ['except' => null],
        'topic' => ['except' => null],
        'sub_topic' => ['except' => null],
    ];

    public function setTab($newTab)
    {
        $this->tab = $newTab;
        $this->resetPage();
    }

    public function selectSubject($slug)
    {
        $this->subject = $slug;
        $this->topic = null;
        $this->sub_topic = null;
        $this->resetPage();
    }

    public function selectChapter($slug)
    {
        $this->topic = $slug;
        $this->sub_topic = null;
        $this->resetPage();
    }

    public function selectTopic($slug)
    {
        $this->sub_topic = $slug;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->subject = null;
        $this->topic = null;
        $this->sub_topic = null;
        $this->resetPage();
    }

    public function render()
    {
        $data = [];

        if ($this->tab === 'exams') {
            $data['exams'] = PastExam::with('institution', 'examCategory')
                ->withCount('questions')
                ->latest('exam_date')
                ->paginate(12);
        } elseif ($this->tab === 'topics') {
            // Load Subjects
            $data['subjects'] = Subject::withCount(['questions' => function($q) {
                $q->has('pastExams');
            }])->having('questions_count', '>', 0)->orderBy('name')->get();

            $currentSubjectObj = $this->subject ? Subject::where('slug', $this->subject)->first() : null;
            $currentChapterObj = $this->topic ? Chapter::where('slug', $this->topic)->first() : null;
            $currentTopicObj = $this->sub_topic ? Topic::where('slug', $this->sub_topic)->first() : null;

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

            $data['questions'] = $query->paginate(15);
            $data['total_questions'] = $query->count();
            
            $data['currentSubject'] = $currentSubjectObj;
            $data['currentChapter'] = $currentChapterObj;
            $data['currentTopic'] = $currentTopicObj;
            
        } elseif ($this->tab === 'organizations') {
            $data['institutions'] = Institution::withCount('pastExams')
                ->orderBy('name')
                ->paginate(12);
        }

        return view('livewire.students.job-solutions.index', $data)
            ->layout('layouts.frontend', ['title' => 'জব সলিউশন (Job Solutions)']);
    }
}

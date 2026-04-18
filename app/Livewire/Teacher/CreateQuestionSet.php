<?php

namespace App\Livewire\Teacher;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\QuestionSet;
use App\Models\Subject;
use App\Models\Topic;
use Livewire\Component;

class CreateQuestionSet extends Component
{
    // Form Properties
    public $name;
    public $type = 'mcq';
    public $quantity;

    // Selection Properties (Blade এ যেভাবে আছে ঠিক সেভাবে)
    public $selectedClass = null;
    public $selectedSubjects = [];
    public $selectedChapters = [];
    public $selectedTopics = [];

    // List Properties (Blade এ যেগুলো ব্যবহার হচ্ছে)
    public $classes = [];
    public $subjects = [];
    public $chapters = [];
    public $topics = [];

    // Validation Rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'selectedClass' => 'required|exists:academic_classes,id',
        'selectedSubjects' => 'required|array|min:1',
        'selectedSubjects.*' => 'exists:subjects,id',
        'selectedChapters' => 'required|array|min:1',
        'selectedChapters.*' => 'exists:chapters,id',
        'type' => 'required|in:mcq,cq,combine',
        'quantity' => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->classes = AcademicClass::orderBy('name')->get();
        $this->subjects = collect();
        $this->chapters = collect();
        $this->topics = collect();
    }

    // ক্লাস পরিবর্তন → সাবজেক্ট লোড
    public function updatedSelectedClass($value)
    {
        if (!empty($value)) {
            $this->subjects = Subject::where('academic_class_id', $value)
                ->orderBy('name')
                ->get();
        } else {
            $this->subjects = collect();
        }

        // নিচের সব রিসেট
        $this->selectedSubjects = [];
        $this->selectedChapters = [];
        $this->selectedTopics = [];
        $this->chapters = collect();
        $this->topics = collect();
    }

    // সাবজেক্ট পরিবর্তন → চ্যাপ্টার লোড
    public function updatedSelectedSubjects()
    {
        if (!empty($this->selectedSubjects)) {
            $this->chapters = Chapter::whereIn('subject_id', $this->selectedSubjects)
                ->orderBy('name')
                ->get();
        } else {
            $this->chapters = collect();
        }

        // নিচের সব রিসেট
        $this->selectedChapters = [];
        $this->selectedTopics = [];
        $this->topics = collect();
    }

    // চ্যাপ্টার পরিবর্তন → টপিক লোড
    public function updatedSelectedChapters()
    {
        if (!empty($this->selectedChapters)) {
            $this->topics = Topic::whereIn('chapter_id', $this->selectedChapters)
                ->orderBy('name')
                ->get();
        } else {
            $this->topics = collect();
        }

        $this->selectedTopics = [];
    }

    public function saveQuestionSet()
    {
        $this->validate();

        // ✅ সবকিছু generation_criteria JSON এ সেভ হবে
        $questionSet = QuestionSet::create([
            'name' => $this->name,
            'user_id' => auth()->id(),
            'generation_criteria' => [
                'academic_class_id' => $this->selectedClass,
                'subject_ids'       => $this->selectedSubjects,
                'chapter_ids'       => $this->selectedChapters,
                'topic_ids'         => $this->selectedTopics,
                'type'              => $this->type,
                'quantity'          => $this->quantity,
            ],
        ]);

        // ফর্ম রিসেট
        $this->reset([
            'name',
            'selectedClass',
            'selectedSubjects',
            'selectedChapters',
            'selectedTopics',
            'type',
            'quantity',
        ]);

        session()->flash('success', 'প্রশ্ন সফলভাবে তৈরি হয়েছে!');

        // রিডাইরেক্ট করতে চাইলে:
         return redirect()->route('qset.generated', ['qset' => $questionSet->id]);
    }

    public function render()
    {
        return view('livewire.teacher.question-set-create')
            ->layout('layouts.app', ['title' => 'প্রশ্ন ক্রিয়েট']);
    }
}

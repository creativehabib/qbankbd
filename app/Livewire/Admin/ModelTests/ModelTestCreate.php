<?php

namespace App\Livewire\Admin\ModelTests;

use App\Models\ModelTest;
use App\Models\Package;
use App\Models\Question;
use App\Models\AcademicClass;
use App\Models\Subject;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ModelTestCreate extends Component
{
    use WithPagination;

    public string $title = '';
    public ?string $description = '';
    public int $duration_minutes = 30;
    public float $negative_mark_weight = 0.25;
    public int $total_marks = 0;
    public bool $is_published = true;
    public bool $is_premium = false;
    public $package_id = '';

    // Filters for questions
    public $class_id = '';
    public $subject_id = '';
    public string $search = '';

    public array $selectedQuestions = [];

    public function updatedClassId()
    {
        $this->subject_id = '';
        $this->resetPage();
    }

    public function updatedSubjectId()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function toggleQuestion($questionId)
    {
        if (in_array($questionId, $this->selectedQuestions)) {
            $this->selectedQuestions = array_diff($this->selectedQuestions, [$questionId]);
        } else {
            $this->selectedQuestions[] = $questionId;
        }
        
        $this->total_marks = count($this->selectedQuestions);
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'negative_mark_weight' => 'required|numeric|min:0',
            'selectedQuestions' => 'required|array|min:1',
        ], [
            'selectedQuestions.required' => 'মডেল টেস্টে অন্তত একটি প্রশ্ন যুক্ত করুন।',
        ]);

        $modelTest = ModelTest::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . time() . '-' . rand(100, 999),
            'description' => $this->description,
            'duration_minutes' => $this->duration_minutes,
            'negative_mark_weight' => $this->negative_mark_weight,
            'total_marks' => count($this->selectedQuestions),
            'is_published' => $this->is_published,
            'is_premium' => $this->is_premium,
            'package_id' => $this->package_id ? $this->package_id : null,
        ]);

        $syncData = [];
        foreach ($this->selectedQuestions as $index => $qId) {
            $syncData[$qId] = ['sort_order' => $index + 1];
        }

        $modelTest->questions()->sync($syncData);

        session()->flash('success', 'মডেল টেস্ট সফলভাবে তৈরি করা হয়েছে!');
        $this->redirectRoute('admin.model-tests.index', navigate: true);
    }

    public function render()
    {
        $query = Question::query()->where('question_type', 'mcq')->where('status', 'active');
        
        if ($this->class_id) {
            $query->where('academic_class_id', $this->class_id);
        }
        if ($this->subject_id) {
            $query->where('subject_id', $this->subject_id);
        }
        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $questions = $query->latest()->paginate(20);

        return view('livewire.admin.model-tests.model-test-create', [
            'questions' => $questions,
            'classes' => AcademicClass::orderBy('name')->get(),
            'subjects' => $this->class_id ? Subject::where('academic_class_id', $this->class_id)->orderBy('name')->get() : collect(),
            'courses' => Package::where('type', 'course')->get(),
        ])->layout('layouts.app', ['title' => 'Create Model Test']);
    }
}

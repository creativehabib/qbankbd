<?php

namespace App\Livewire\Admin\PastExams;

use App\Models\Institution;
use App\Models\PastExam;
use App\Models\ExamCategory;
use Livewire\Component;
use Livewire\WithPagination;

class PastExamIndex extends Component
{
    use WithPagination;

    public $title = '';
    public $description = '';
    public $slug = '';
    public $institution_id = '';
    public $exam_category_id = '';
    public $exam_date = '';
    public $grade = '';
    public $total_marks = '';
    public $total_questions = '';
    public $type = 'mcq';
    
    public $editingId = null;
    public $showModal = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'slug' => 'nullable|string|max:255',
        'institution_id' => 'nullable|exists:institutions,id',
        'exam_category_id' => 'nullable|exists:exam_categories,id',
        'exam_date' => 'nullable|date',
        'grade' => 'nullable|string',
        'total_marks' => 'nullable|integer',
        'total_questions' => 'nullable|integer',
        'type' => 'required|in:mcq,cq,short,written,both',
    ];

    public function create()
    {
        $this->reset(['title', 'slug', 'description', 'institution_id', 'exam_category_id', 'exam_date', 'grade', 'total_marks', 'total_questions', 'type', 'editingId']);
        $this->type = 'mcq';
        $this->showModal = true;
    }

    public function edit($id)
    {
        $exam = PastExam::findOrFail($id);
        $this->editingId = $exam->id;
        $this->title = $exam->title;
        $this->description = $exam->description;
        $this->slug = $exam->slug;
        $this->institution_id = $exam->institution_id;
        $this->exam_category_id = $exam->exam_category_id;
        $this->exam_date = $exam->exam_date ? $exam->exam_date->format('Y-m-d') : '';
        $this->grade = $exam->grade;
        $this->total_marks = $exam->total_marks;
        $this->total_questions = $exam->total_questions;
        $this->type = $exam->type ?? 'mcq';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'institution_id' => $this->institution_id ?: null,
            'exam_category_id' => $this->exam_category_id ?: null,
            'exam_date' => $this->exam_date ?: null,
            'grade' => $this->grade,
            'total_marks' => $this->total_marks ?: null,
            'total_questions' => $this->total_questions ?: null,
            'type' => $this->type,
        ];

        if ($this->editingId) {
            PastExam::findOrFail($this->editingId)->update($data);
        } else {
            PastExam::create($data);
        }

        $this->showModal = false;
        $this->reset(['title', 'slug', 'description', 'institution_id', 'exam_category_id', 'exam_date', 'grade', 'total_marks', 'total_questions', 'type', 'editingId']);
    }

    public function delete($id)
    {
        PastExam::findOrFail($id)->delete();
    }

    public function render()
    {
        return view('livewire.admin.past-exams.past-exam-index', [
            'exams' => PastExam::with('institution')->latest()->paginate(10),
            'institutions' => Institution::orderBy('name')->get(),
            'categories' => ExamCategory::orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Past Exams']);
    }
}

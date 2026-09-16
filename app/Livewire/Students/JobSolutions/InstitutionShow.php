<?php

namespace App\Livewire\Students\JobSolutions;

use App\Models\Institution;
use Livewire\Component;
use Livewire\WithPagination;

class InstitutionShow extends Component
{
    use WithPagination;

    public $institution;
    public $type = 'all';

    public function mount($institutionSlug)
    {
        $this->institution = Institution::where('slug', $institutionSlug)->firstOrFail();
    }

    
    public function setType($type)
    {
        $this->type = $type;
        $this->resetPage();
    }

    public function render()
    {
        $query = $this->institution->pastExams()->with('examCategory')->withCount('questions');
        if ($this->type !== 'all') {
            $query->where('type', $this->type);
        }
        $exams = $query->latest('exam_date')->paginate(15);

        return view('livewire.students.job-solutions.institution-show', [
            'exams' => $exams
        ])->layout('layouts.frontend', ['title' => $this->institution->name . ' - জব সলিউশন']);
    }
}

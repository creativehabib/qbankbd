<?php

namespace App\Livewire\Subjects;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\AcademicClass;
use App\Models\Question;
use App\Models\Subject;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class SubjectIndex extends Component
{
    public $toggleTargetId = null;

    public $toggleTargetName = '';

    public $toggleTargetState = false;

    public $showToggleModal = false;

    public $isCreating = false;

    use InteractsWithFluxToasts;
    use WithPagination;

    public $search = '';

    public $perPage = 10;

    public $sortField = 'default';

    // Form Properties
    public $editId = null;

    public $academic_class_id = '';

    public $name = '';

    public $subject_code = '';

    public $description = '';

    public $is_active = true;

    public $is_premium = false;

    public $image;

    protected $listeners = ['deleteSubjectConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function cancelEdit()
    {
        $this->isCreating = false;
        $this->reset([
            'editId', 'academic_class_id', 'name', 'subject_code',
            'description', 'image',
        ]);
        $this->is_active = true;
        $this->is_premium = false;
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->cancelEdit();
        $this->dispatch('open-subject-modal');
    }

    public function edit($id)
    {
        $this->isCreating = false;
        $this->resetValidation();
        $subject = Subject::findOrFail($id);

        $this->editId = $subject->id;
        $this->academic_class_id = $subject->academic_class_id;
        $this->name = $subject->name;
        $this->subject_code = $subject->subject_code;
        $this->description = $subject->description;
        $this->is_active = $subject->is_active;
        $this->is_premium = $subject->is_premium;
        $this->image = $subject->image;

        // ডেটা লোড হওয়ার পর মডাল ওপেন হবে
        $this->dispatch('open-subject-modal');
    }

    public function save()
    {
        $this->validate([
            'academic_class_id' => 'required|exists:academic_classes,id',
            'name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $slug = Str::slug($this->name);
        $slugExists = Subject::where('slug', $slug)->where('id', '!=', $this->editId)->exists();
        if ($slugExists) {
            $slug .= '-'.time();
        }

        $data = [
            'academic_class_id' => $this->academic_class_id,
            'name' => $this->name,
            'subject_code' => $this->subject_code,
            'slug' => $slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'image' => $this->image,
        ];

        if ($this->editId) {
            Subject::where('id', $this->editId)->update($data);
            $message = 'Subject updated successfully!';
        } else {
            $data['uuid'] = (string) Str::uuid();
            $data['order_sequence'] = Subject::max('order_sequence') + 1 ?? 1;
            Subject::create($data);
            $message = 'Subject created successfully!';
        }

        // সেভ হওয়ার পর মডাল বন্ধের সিগন্যাল এবং টোস্ট মেসেজ
        $this->dispatch('close-subject-modal');
        $this->dispatch('subjectSaved', message: $message);
        $this->toastSuccess($message);
    }

    public function delete($id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            // Check if attached to any question
            $hasQuestions = Question::where('subject_id', $id)->exists();
            if ($hasQuestions) {
                $this->toastWarning('This subject is attached to questions, so it cannot be deleted. You can deactivate it instead.', 'Cannot Delete');

                return;
            }

            $subject->delete();
            $this->resetPage();
            $this->dispatch('subjectDeleted', message: 'Subject deleted successfully.');
            $this->toastSuccess('Subject deleted successfully.');
        }
    }

    public function toggleActive($id)
    {
        $item = Subject::findOrFail($id);
        $this->toggleTargetId = $id;
        $this->toggleTargetName = $item->name;
        $this->toggleTargetState = ! $item->is_active;

        // Open modal via Flux
        $this->showToggleModal = true;
    }

    public function performToggle()
    {
        if (! $this->toggleTargetId) {
            return;
        }

        $item = Subject::findOrFail($this->toggleTargetId);
        $item->is_active = $this->toggleTargetState;
        $item->save();

        $this->toastSuccess('Status updated successfully.');
        $this->showToggleModal = false;
        $this->toggleTargetId = null;
    }

    public function create()
    {
        $this->cancelEdit();
        $this->isCreating = true;
    }

    public function render()
    {
        $subjects = Subject::withCount('questions')->with('academicClass')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('subject_code', 'like', '%'.$this->search.'%');
            })
            ->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
            ->paginate($this->perPage);

        $classes = AcademicClass::orderBy('name')->get();

        return view('livewire.subjects.subject-index', compact('subjects', 'classes'))
            ->layout('layouts.app', ['title' => 'Manage Subjects']);
    }
}

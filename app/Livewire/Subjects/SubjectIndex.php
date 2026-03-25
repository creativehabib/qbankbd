<?php

namespace App\Livewire\Subjects;

use App\Models\Subject;
use App\Models\AcademicClass;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class SubjectIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';

    // Form Properties
    public $editId = null;
    public $academic_class_id = '';
    public $name = '';
    public $subject_code = '';
    public $description = '';
    public $is_active = true;
    public $is_premium = false;
    public $newImage;
    public $oldImage;

    protected $listeners = ['deleteSubjectConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function openModal()
    {
        // ১. আগে ডেটা রিসেট হবে
        $this->reset([
            'editId', 'academic_class_id', 'name', 'subject_code',
            'description', 'newImage', 'oldImage'
        ]);
        $this->is_active = true;
        $this->is_premium = false;
        $this->resetValidation();

        // ২. সব কাজ শেষ হলে ব্রাউজারে সিগন্যাল পাঠাবে মডাল ওপেন করার জন্য
        $this->dispatch('open-subject-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $subject = Subject::findOrFail($id);

        $this->editId = $subject->id;
        $this->academic_class_id = $subject->academic_class_id;
        $this->name = $subject->name;
        $this->subject_code = $subject->subject_code;
        $this->description = $subject->description;
        $this->is_active = $subject->is_active;
        $this->is_premium = $subject->is_premium;
        $this->oldImage = $subject->image;

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
            'newImage' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($this->name);
        $slugExists = Subject::where('slug', $slug)->where('id', '!=', $this->editId)->exists();
        if ($slugExists) {
            $slug .= '-' . time();
        }

        $data = [
            'academic_class_id' => $this->academic_class_id,
            'name' => $this->name,
            'subject_code' => $this->subject_code,
            'slug' => $slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('subjects', 'public');
        }

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
    }

    public function delete($id)
    {
        $subject = Subject::find($id);
        if ($subject) {
            $subject->delete();
            $this->resetPage();
            $this->dispatch('subjectDeleted', message: 'Subject deleted successfully.');
        }
    }

    public function render()
    {
        $subjects = Subject::with('academicClass')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('subject_code', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        $classes = AcademicClass::orderBy('name')->get();

        return view('livewire.subjects.subject-index', compact('subjects', 'classes'))
            ->layout('layouts.app', ['title' => 'Manage Subjects']);
    }
}

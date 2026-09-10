<?php

namespace App\Livewire\Chapters;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ChapterIndex extends Component
{
    use InteractsWithFluxToasts;
    use WithPagination;

    public string $search = '';

    // Form Properties
    public $editId = null;

    public string $subject_id = '';

    public string $academic_class_id = '';

    public string $name = '';

    public string $description = '';

    public bool $is_active = true;

    public bool $is_premium = false;

    public $image;

    protected $listeners = ['deleteSubjectConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function cancelEdit()
    {
        $this->reset([
            'editId', 'subject_id', 'name',
            'academic_class_id', 'description', 'image',
        ]);
        $this->is_active = true;
        $this->is_premium = false;
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->cancelEdit();
        $this->dispatch('open-chapter-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $chapter = Chapter::with('subject.academicClass')->findOrFail($id);

        $this->editId = $chapter->id;
        $this->subject_id = (string) $chapter->subject_id;
        $this->academic_class_id = (string) ($chapter->subject?->academic_class_id ?? '');
        $this->name = $chapter->name;
        $this->description = $chapter->description;
        $this->is_active = $chapter->is_active;
        $this->is_premium = $chapter->is_premium;
        $this->image = $chapter->image;

        // ডেটা লোড হওয়ার পর মডাল ওপেন হবে
        $this->dispatch('open-chapter-modal');
    }

    public function save()
    {
        $validated = $this->validate([
            'academic_class_id' => 'required|exists:academic_classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'image' => 'nullable|string',
        ]);

        $subject = Subject::query()
            ->whereKey($validated['subject_id'])
            ->where('academic_class_id', $validated['academic_class_id'])
            ->first();

        if (! $subject) {
            $this->addError('subject_id', 'Please select a subject from the selected class.');

            return;
        }

        $slug = Str::slug($this->name);
        $slugExists = Chapter::where('slug', $slug)->where('id', '!=', $this->editId)->exists();
        if ($slugExists) {
            $slug .= '-'.time();
        }

        $data = [
            'subject_id' => $subject->id,
            'name' => $this->name,
            'slug' => $slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'image' => $this->image,
        ];

        if ($this->editId) {
            Chapter::where('id', $this->editId)->update($data);
            $message = 'Chapter updated successfully!';
        } else {
            $data['uuid'] = (string) Str::uuid();
            $data['order_sequence'] = Chapter::max('order_sequence') + 1 ?? 1;
            Chapter::create($data);
            $message = 'Chapter created successfully!';
        }

        // সেভ হওয়ার পর মডাল বন্ধের সিগন্যাল এবং টোস্ট মেসেজ
        $this->dispatch('close-chapter-modal');
        $this->dispatch('chapterSaved', message: $message);
        $this->toastSuccess($message);
    }

    public function delete($id)
    {
        $chapter = Chapter::find($id);
        if ($chapter) {
            $hasQuestions = \App\Models\Question::where('chapter_id', $id)->exists();
            if ($hasQuestions) {
                $this->toastWarning('This chapter is attached to questions, so it cannot be deleted. You can deactivate it instead.', 'Cannot Delete');
                return;
            }

            $chapter->delete();
            $this->resetPage();
            $this->dispatch('subjectDeleted', message: 'Chapter deleted successfully.');
            $this->toastSuccess('Chapter deleted successfully.');
        }
    }

    public function updatedAcademicClassId(): void
    {
        $this->subject_id = '';
    }

    public function render()
    {
        $chapters = Chapter::with('subject.academicClass')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        $subjects = Subject::query()
            ->with('academicClass')
            ->when($this->academic_class_id !== '', function ($query): void {
                $query->where('academic_class_id', $this->academic_class_id);
            })
            ->orderBy(AcademicClass::query()->select('name')->whereColumn('academic_classes.id', 'subjects.academic_class_id'))
            ->orderBy('name')
            ->get();

        $classes = AcademicClass::query()->orderBy('name')->get();

        return view('livewire.chapters.chapter-index', compact('chapters', 'subjects', 'classes'))
            ->layout('layouts.app', ['title' => 'Manage Chapters']);
    }
}

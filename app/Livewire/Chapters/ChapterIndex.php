<?php

namespace App\Livewire\Chapters;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Subject;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ChapterIndex extends Component
{
    use WithFileUploads, WithPagination;

    public string $search = '';

    // Form Properties
    public $editId = null;

    public string $subject_id = '';

    public string $name = '';

    public string $description = '';

    public bool $is_active = true;

    public bool $is_premium = false;

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
            'editId', 'subject_id', 'name',
            'description', 'newImage', 'oldImage',
        ]);
        $this->is_active = true;
        $this->is_premium = false;
        $this->resetValidation();

        // ২. সব কাজ শেষ হলে ব্রাউজারে সিগন্যাল পাঠাবে মডাল ওপেন করার জন্য
        $this->dispatch('open-chapter-modal');
    }

    public function edit($id)
    {
        $this->resetValidation();
        $subject = Chapter::findOrFail($id);

        $this->editId = $subject->id;
        $this->subject_id = $subject->subject_id;
        $this->name = $subject->name;
        $this->description = $subject->description;
        $this->is_active = $subject->is_active;
        $this->is_premium = $subject->is_premium;
        $this->oldImage = $subject->image;

        // ডেটা লোড হওয়ার পর মডাল ওপেন হবে
        $this->dispatch('open-chapter-modal');
    }

    public function save()
    {
        $this->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'newImage' => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($this->name);
        $slugExists = Chapter::where('slug', $slug)->where('id', '!=', $this->editId)->exists();
        if ($slugExists) {
            $slug .= '-'.time();
        }

        $data = [
            'subject_id' => $this->subject_id,
            'name' => $this->name,
            'slug' => $slug,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
        ];

        if ($this->newImage) {
            $data['image'] = $this->newImage->store('chapters', 'public');
        }

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
    }

    public function delete($id)
    {
        $subject = Chapter::find($id);
        if ($subject) {
            $subject->delete();
            $this->resetPage();
            $this->dispatch('subjectDeleted', message: 'Subject deleted successfully.');
        }
    }

    public function render()
    {
        $chapters = Chapter::with('subject')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('like', '%'.$this->search.'%');
            })
            ->orderBy('name')
            ->paginate(10);

        $subjects = Subject::orderBy('name')->get();

        return view('livewire.chapters.chapter-index', compact('chapters', 'subjects'))
            ->layout('layouts.app', ['title' => 'Manage Chapters']);
    }
}

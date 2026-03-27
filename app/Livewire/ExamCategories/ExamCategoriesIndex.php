<?php

namespace App\Livewire\ExamCategories;

use App\Models\ExamCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ExamCategoriesIndex extends Component
{
    use WithPagination;

    public $search = '';

    // Modal Properties
    public $showModal = false; // <-- এই প্রোপার্টিটি যুক্ত করা হয়েছে
    public $name = '';
    public $editId = null;

    protected $listeners = ['deleteExamCategoryConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    // ক্রিয়েট বাটনে ক্লিক করলে ফর্ম রিসেট হবে এবং মডাল ওপেন হবে
    public function openModal()
    {
        $this->reset(['name', 'editId']);
        $this->resetValidation();
        $this->showModal = true; // <-- মডাল ওপেন করার জন্য true করা হলো
    }

    // এডিট বাটনে ক্লিক করলে ডেটা লোড হবে এবং মডাল ওপেন হবে
    public function edit($id)
    {
        $this->resetValidation();
        $examCategory = ExamCategory::findOrFail($id);

        $this->editId = $examCategory->id;
        $this->name = $examCategory->name;

        $this->showModal = true; // <-- মডাল ওপেন করার জন্য true করা হলো
    }

    // সেভ বা আপডেট করার মেথড
    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('exam_categories', 'name')->ignore($this->editId),
            ],
        ]);

        // Name থেকে অটোমেটিক Slug তৈরি করা হচ্ছে
        $slug = Str::slug($this->name);

        if ($this->editId) {
            // Update
            $examCategory = ExamCategory::find($this->editId);
            $examCategory->update([
                'name' => $this->name,
                'slug' => $slug,
            ]);
            $message = 'Exam Category updated successfully!';
        } else {
            // Create
            ExamCategory::create([
                'name' => $this->name,
                'slug' => $slug,
            ]);
            $message = 'Exam Category created successfully!';
        }

        $this->reset(['name', 'editId']);
        $this->showModal = false; // <-- সেভ হওয়ার পর মডাল ক্লোজ করার জন্য false করা হলো

        $this->dispatch('examCategorySaved', message: $message);
    }

    // ডিলিট করার মেথড
    public function delete($id)
    {
        $examCategory = ExamCategory::find($id);
        if ($examCategory) {
            $examCategory->delete();
            $this->resetPage();
            $this->dispatch('examCategoryDeleted', message: 'Exam category deleted successfully.');
        }
    }

    public function render()
    {
        $examCategories = ExamCategory::when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
        )->orderBy('name')->paginate(10);

        return view('livewire.exam-categories.exam-categories-index', [
            'examCategories' => $examCategories,
        ])->layout('layouts.app', ['title' => 'Manage Exam Categories']);
    }
}

<?php

namespace App\Livewire\ExamCategories;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\ExamCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ExamCategoriesIndex extends Component
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

    // Modal Properties
    public $showModal = false; // <-- এই প্রোপার্টিটি যুক্ত করা হয়েছে

    public $name = '';

    public $editId = null;

    protected $listeners = ['deleteExamCategoryConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function cancelEdit()
    {
        $this->isCreating = false;
        $this->reset(['isCreating', 'name', 'editId']);
        $this->resetValidation();
    }

    public function openModal()
    {
        $this->cancelEdit();
    }

    public function edit($id)
    {
        $this->isCreating = false;
        $this->resetValidation();
        $examCategory = ExamCategory::findOrFail($id);

        $this->editId = $examCategory->id;
        $this->name = $examCategory->name;
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

        $this->reset(['isCreating', 'name', 'editId']);

        $this->dispatch('examCategorySaved', message: $message);
        $this->toastSuccess($message);
    }

    // ডিলিট করার মেথড
    public function delete($id)
    {
        $examCategory = ExamCategory::find($id);
        if ($examCategory) {
            $hasQuestions = $examCategory->questions()->exists();
            if ($hasQuestions) {
                $this->toastWarning('This exam category is attached to questions, so it cannot be deleted.', 'Cannot Delete');

                return;
            }

            $examCategory->delete();
            $this->resetPage();
            $this->dispatch('examCategoryDeleted', message: 'Exam category deleted successfully.');
            $this->toastSuccess('Exam category deleted successfully.');
        }
    }

    public function create()
    {
        $this->cancelEdit();
        $this->isCreating = true;
    }

    public function toggleActive($id)
    {
        $item = ExamCategory::findOrFail($id);
        $this->toggleTargetId = $id;
        $this->toggleTargetName = $item->name;
        $this->toggleTargetState = ! $item->is_active;

        // Open modal via Flux
        $this->showToggleModal = true;
        $this->dispatch('modal-show', name: 'toggle-confirm');
    }

    public function performToggle()
    {
        if (! $this->toggleTargetId) {
            return;
        }

        $item = ExamCategory::findOrFail($this->toggleTargetId);
        $item->is_active = $this->toggleTargetState;
        $item->save();

        $this->toastSuccess('Status updated successfully.');
        $this->showToggleModal = false;
        $this->dispatch('modal-close', name: 'toggle-confirm');
        $this->toggleTargetId = null;
    }

    public function render()
    {
        $examCategories = ExamCategory::withCount('questions')->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%')
        )->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())->paginate($this->perPage);

        return view('livewire.exam-categories.exam-categories-index', [
            'examCategories' => $examCategories,
        ])->layout('layouts.app', ['title' => 'Manage Exam Categories']);
    }
}

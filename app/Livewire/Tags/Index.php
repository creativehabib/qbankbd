<?php

namespace App\Livewire\Tags;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $toggleTargetId = null;

    public $toggleTargetName = '';

    public $toggleTargetState = false;

    public $showToggleModal = false;

    public $isCreating = false;

    public $perPage = 10;

    public $sortField = 'default';

    use InteractsWithFluxToasts;
    use WithPagination;

    public string $name = '';

    public ?int $editingId = null;

    public string $search = '';

    protected $listeners = [
        'tagDeleted' => '$refresh',
        'deleteTagConfirmed' => 'delete',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function save(): void
    {
        if ($this->editingId) {
            abort_unless(auth()->user()?->hasPermission('tags.update'), 403);
            $this->validate([
                'name' => 'required|string|unique:tags,name,'.$this->editingId,
            ]);

            Tag::query()->withCount('questions')->findOrFail($this->editingId)->update(['name' => $this->name]);

            $this->isCreating = false;
            $this->editingId = null;
            $this->name = '';
            $this->dispatch('tagUpdated', message: 'Tag updated successfully.');
            $this->toastSuccess('Tag updated successfully.');
        } else {
            abort_unless(auth()->user()?->hasPermission('tags.create'), 403);
            $this->validate([
                'name' => 'required|string|unique:tags,name',
            ]);

            Tag::query()->withCount('questions')->create([
                'name' => $this->name,
            ]);

            $this->isCreating = false;
            $this->name = '';
            $this->resetPage();
            $this->dispatch('tagSaved', message: 'Tag added successfully.');
            $this->toastSuccess('Tag added successfully.');
        }
    }

    public function delete(int $id): void
    {
        abort_unless(auth()->user()?->hasPermission('tags.delete'), 403);

        $tag = Tag::query()->withCount('questions')->findOrFail($id);

        $hasQuestions = $tag->questions()->exists();
        if ($hasQuestions) {
            $this->toastWarning('This tag is attached to questions, so it cannot be deleted.', 'Cannot Delete');

            return;
        }

        $tag->delete();

        $this->resetPage();
        $this->dispatch('tagDeleted', message: 'Tag deleted successfully.');
        $this->toastSuccess('Tag deleted successfully.');
    }

    public function edit(int $id): void
    {
        $this->isCreating = false;
        abort_unless(auth()->user()?->hasPermission('tags.update'), 403);

        $tag = Tag::query()->withCount('questions')->findOrFail($id);
        $this->editingId = $tag->id;
        $this->name = $tag->name;
    }

    public function cancelEdit(): void
    {
        $this->isCreating = false;
        $this->editingId = null;
        $this->name = '';
    }

    public function create()
    {
        $this->cancelEdit();
        $this->isCreating = true;
    }

    public function toggleActive($id)
    {
        $item = Tag::findOrFail($id);
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

        $item = Tag::findOrFail($this->toggleTargetId);
        $item->is_active = $this->toggleTargetState;
        $item->save();

        $this->toastSuccess('Status updated successfully.');
        $this->showToggleModal = false;
        $this->toggleTargetId = null;
    }

    public function render()
    {
        abort_unless(
            auth()->user()?->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']),
            403
        );

        $tags = Tag::query()->withCount('questions')
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
            ->paginate($this->perPage);

        return view('livewire.admin.tags.index', [
            'tags' => $tags,
            'canCreate' => auth()->user()?->hasPermission('tags.create') ?? false,
            'canUpdate' => auth()->user()?->hasPermission('tags.update') ?? false,
            'canDelete' => auth()->user()?->hasPermission('tags.delete') ?? false,
        ])->layout('layouts.app', ['title' => 'Manage Tags']);
    }
}

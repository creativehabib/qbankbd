<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $name = '';

    public ?int $editingId = null;

    public string $editingName = '';

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
        abort_unless(auth()->user()?->hasPermission('tags.create'), 403);

        $this->validate([
            'name' => 'required|string|unique:tags,name',
        ]);

        Tag::query()->create([
            'name' => $this->name,
        ]);

        $this->name = '';
        $this->resetPage();
        $this->dispatch('tagSaved', message: 'Tag added successfully.');
    }

    public function delete(int $id): void
    {
        abort_unless(auth()->user()?->hasPermission('tags.delete'), 403);

        Tag::query()->findOrFail($id)->delete();

        $this->resetPage();
        $this->dispatch('tagDeleted', message: 'Tag deleted successfully.');
    }

    public function edit(int $id): void
    {
        abort_unless(auth()->user()?->hasPermission('tags.update'), 403);

        $tag = Tag::query()->findOrFail($id);
        $this->editingId = $tag->id;
        $this->editingName = $tag->name;
    }

    public function update(): void
    {
        abort_unless(auth()->user()?->hasPermission('tags.update'), 403);

        $this->validate([
            'editingName' => 'required|string|unique:tags,name,'.$this->editingId,
        ]);

        Tag::query()->findOrFail($this->editingId)->update(['name' => $this->editingName]);

        $this->editingId = null;
        $this->editingName = '';
        $this->dispatch('tagUpdated', message: 'Tag updated successfully.');
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editingName = '';
    }

    public function render()
    {
        abort_unless(
            auth()->user()?->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']),
            403
        );

        $tags = Tag::query()
            ->when($this->search, fn ($query) => $query->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.tags.index', [
            'tags' => $tags,
            'canCreate' => auth()->user()?->hasPermission('tags.create') ?? false,
            'canUpdate' => auth()->user()?->hasPermission('tags.update') ?? false,
            'canDelete' => auth()->user()?->hasPermission('tags.delete') ?? false,
        ])->layout('layouts.app', ['title' => 'Manage Tags']);
    }
}

<?php

namespace App\Livewire\Topics;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic; // <-- Str ক্লাস ইমপোর্ট করা হলো
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TopicIndex extends Component
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

    public $subjectId = '';

    // Modal Properties
    public $showModal = false;

    public $name = '';

    public $modalSubjectId = '';

    public $modalChapterId = null;

    public $editId = null;

    protected $listeners = ['deleteTopicConfirmed' => 'delete'];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSubjectId(): void
    {
        $this->resetPage();
    }

    public function updatedModalSubjectId()
    {
        $this->modalChapterId = null;
    }

    public function cancelEdit()
    {
        $this->isCreating = false;
        $this->reset(['isCreating', 'name', 'modalSubjectId', 'modalChapterId', 'editId']);
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
        $topic = Topic::findOrFail($id);

        $this->editId = $topic->id;
        $this->modalSubjectId = $topic->subject_id;
        $this->modalChapterId = $topic->chapter_id;
        $this->name = $topic->name;
    }

    public function save()
    {
        $this->validate([
            'modalSubjectId' => 'required|exists:subjects,id',
            'modalChapterId' => 'nullable|exists:chapters,id',
            'name' => [
                'required',
                'string',
                Rule::unique('topics', 'name')
                    ->where('subject_id', $this->modalSubjectId)
                    ->where('chapter_id', $this->modalChapterId)
                    ->ignore($this->editId),
            ],
        ]);

        // Name থেকে অটোমেটিক Slug তৈরি করা হচ্ছে
        // (বাংলা টেক্সট হলে স্পেসের জায়গায় ড্যাশ বসিয়ে স্লাগ তৈরি করার জন্য কাস্টম লজিক ব্যবহার করা হলো)
        $slug = preg_replace('/\s+/u', '-', trim($this->name));

        if ($this->editId) {
            // Update
            Topic::find($this->editId)->update([
                'subject_id' => $this->modalSubjectId,
                'chapter_id' => $this->modalChapterId ?: null,
                'name' => $this->name,
                'slug' => $slug, // <-- Slug আপডেট করা হলো
            ]);
            $message = 'Topic updated successfully!';
        } else {
            // Create
            Topic::create([
                'subject_id' => $this->modalSubjectId,
                'chapter_id' => $this->modalChapterId ?: null,
                'name' => $this->name,
                'slug' => $slug, // <-- Slug সেভ করা হলো
            ]);
            $message = 'Topic created successfully!';
        }

        $this->reset(['isCreating', 'name', 'modalSubjectId', 'modalChapterId', 'editId']);
        $this->dispatch('topicSaved', message: $message);
        $this->toastSuccess($message);
    }

    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic) {
            $hasQuestions = Question::where('topic_id', $id)->exists();
            if ($hasQuestions) {
                $this->toastWarning('This topic is attached to questions, so it cannot be deleted. You can deactivate it instead.', 'Cannot Delete');

                return;
            }

            $topic->delete();
            $this->resetPage();
            $this->dispatch('topicDeleted', message: 'Topic deleted successfully.');
            $this->toastSuccess('Topic deleted successfully.');
        }
    }

    public function create()
    {
        $this->cancelEdit();
        $this->isCreating = true;
    }

    public function toggleActive($id)
    {
        $item = Topic::findOrFail($id);
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

        $item = Topic::findOrFail($this->toggleTargetId);
        $item->is_active = $this->toggleTargetState;
        $item->save();

        $this->toastSuccess('Status updated successfully.');
        $this->showToggleModal = false;
        $this->toggleTargetId = null;
    }

    public function render()
    {
        $topics = Topic::with('subject', 'chapter')->withCount('questions')
            ->when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
            ->paginate($this->perPage);

        $modalChapters = $this->modalSubjectId
            ? Chapter::where('subject_id', $this->modalSubjectId)->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
                ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
                ->when($this->sortField === 'default', fn ($q) => $q->latest())->get()
            : [];

        return view('livewire.topics.topic-index', [
            'topics' => $topics,
            'subjects' => Subject::orderBy('name')->get(),
            'modalChapters' => $modalChapters,
        ])->layout('layouts.app', ['title' => 'Manage Topics']);
    }
}

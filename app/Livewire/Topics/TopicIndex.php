<?php

namespace App\Livewire\Topics;

use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Str; // <-- Str ক্লাস ইমপোর্ট করা হলো
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TopicIndex extends Component
{
    use WithPagination;

    public $search = '';
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

    public function openModal()
    {
        $this->reset(['name', 'modalSubjectId', 'modalChapterId', 'editId']);
        $this->resetValidation();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->resetValidation();
        $topic = Topic::findOrFail($id);

        $this->editId = $topic->id;
        $this->modalSubjectId = $topic->subject_id;
        $this->modalChapterId = $topic->chapter_id;
        $this->name = $topic->name;

        $this->showModal = true;
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

        $this->reset(['name', 'modalSubjectId', 'modalChapterId', 'editId']);
        $this->showModal = false;
        $this->dispatch('topicSaved', message: $message);
    }

    public function delete($id)
    {
        $topic = Topic::find($id);
        if ($topic) {
            $topic->delete();
            $this->resetPage();
            $this->dispatch('topicDeleted', message: 'Topic deleted successfully.');
        }
    }

    public function render()
    {
        $topics = Topic::with('subject', 'chapter')
            ->when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->orderBy('name')
            ->paginate(10);

        $modalChapters = $this->modalSubjectId
            ? Chapter::where('subject_id', $this->modalSubjectId)->orderBy('name')->get()
            : [];

        return view('livewire.topics.topic-index', [
            'topics' => $topics,
            'subjects' => Subject::orderBy('name')->get(),
            'modalChapters' => $modalChapters,
        ])->layout('layouts.app', ['title' => 'Manage Topics']);
    }
}

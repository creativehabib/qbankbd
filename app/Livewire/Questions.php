<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use AuthorizesRequests, WithPagination;

    /**
     * Search term for filtering questions.
     */
    public $search = '';

    /**
     * Selected subject filter.
     */
    public $subjectId = '';

    /**
     * Selected topic filter.
     */
    public $topicId = '';

    /**
     * Refresh the component when a question is deleted.
     *
     * @var array
     */
    protected $listeners = [
        'questionDeleted' => '$refresh',
        'deleteQuestionConfirmed' => 'deleteQuestion',
    ];

    /**
     * Reset the pagination when the search term is updated.
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingSubjectId(): void
    {
        $this->resetPage();
        $this->topicId = '';
    }

    public function updatingTopicId(): void
    {
        $this->resetPage();
    }

    /**
     * Permanently delete a question along with its relations.
     */
    public function deleteQuestion(int $id): void
    {
        $question = Question::with(['tags', 'options'])->findOrFail($id);

        $this->authorize('delete', $question);

        $question->tags()->detach();
        $question->options()->delete();

        $question->forceDelete();

        $this->dispatch('questionDeleted', message: 'Question deleted successfully.');
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        $questions = Question::with('subject', 'topic')
            ->when($user->isTeacher(), fn ($q) => $q->where('user_id', $user->id))
            ->when($this->search, function ($q) {
                $search = '%'.$this->search.'%';
                $q->where('title', 'like', $search)
                    ->orWhereRelation('subject', 'name', 'like', $search)
                    ->orWhereRelation('topic', 'name', 'like', $search);
            })
            ->when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
            ->when($this->topicId, fn ($q) => $q->where('topic_id', $this->topicId))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions', [
            'questions' => $questions,
            'subjects' => Subject::orderBy('name')->get(),
            'topics' => Topic::when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
                ->orderBy('name')
                ->get(),
        ])->layout($user->isAdmin() ? 'layouts.admin' : 'layouts.panel', ['title' => 'Manage Questions']);
    }
}

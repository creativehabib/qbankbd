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
     * Selected status filter.
     */
    public $statusFilter = '';

    /**
     * Refresh the component when a question is deleted.
     *
     * @var array
     */
    protected $listeners = [
        'questionDeleted' => '$refresh',
        'deleteQuestionConfirmed' => 'deleteQuestion',
        'toggleQuestionStatusConfirmed' => 'toggleQuestionStatus',
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

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Permanently delete a question along with its relations.
     */
    public function deleteQuestion(int $id): void
    {
        $question = Question::with(['tags'])->findOrFail($id);

        abort_unless(auth()->user()?->hasPermission('questions.delete'), 403);

        if (auth()->user()?->isTeacher() && (int) $question->user_id !== (int) auth()->id()) {
            abort(404);
        }

        $question->tags()->detach();

        $question->forceDelete();

        $this->dispatch('questionDeleted', message: 'Question deleted successfully.');
        $this->resetPage();
    }

    public function toggleQuestionStatus(int $id): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.publish'), 403);

        $question = Question::query()->findOrFail($id);
        $nextStatus = $question->status === 'active' ? 'pending' : 'active';
        $question->update(['status' => $nextStatus]);

        $message = $nextStatus === 'active'
            ? 'Question approved successfully.'
            : 'Question moved back to pending successfully.';

        $this->dispatch('questionStatusUpdated', message: $message);
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();

        $baseQuery = Question::query()
            ->when($user->isTeacher(), fn ($q) => $q->where('user_id', $user->id));

        $activeQuestionsCount = (clone $baseQuery)->where('status', 'active')->count();
        $inactiveQuestionsCount = (clone $baseQuery)->where('status', 'inactive')->count();

        $questions = Question::with('subject', 'topic', 'user')
            ->when($user->isTeacher(), fn ($q) => $q->where('user_id', $user->id))
            ->when($this->search, function ($q) {
                $search = '%'.$this->search.'%';
                $q->where('title', 'like', $search)
                    ->orWhereRelation('subject', 'name', 'like', $search)
                    ->orWhereRelation('topic', 'name', 'like', $search);
            })
            ->when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
            ->when($this->topicId, fn ($q) => $q->where('topic_id', $this->topicId))
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions', [
            'questions' => $questions,
            'subjects' => Subject::orderBy('name')->get(),
            'topics' => Topic::when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
                ->orderBy('name')
                ->get(),
            'activeQuestionsCount' => $activeQuestionsCount,
            'inactiveQuestionsCount' => $inactiveQuestionsCount,
        ])->layout('layouts.app', ['title' => 'All Questions']);
    }
}

<?php

namespace App\Livewire;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use InteractsWithFluxToasts;
    private const QUESTION_EARNING_AMOUNT = 10;

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
     * Selected question type filter.
     */
    public $questionTypeFilter = '';

    /**
     * Quick tab filter.
     */
    public $quickFilter = 'all';

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

    public function updatingQuestionTypeFilter(): void
    {
        $this->resetPage();
    }

    public function setQuickFilter(string $filter): void
    {
        $this->quickFilter = $filter;
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
        $this->toastSuccess('Question deleted successfully.');
        $this->resetPage();
    }

    public function toggleQuestionStatus(int $id): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.publish'), 403);

        $question = Question::query()->findOrFail($id);
        $nextStatus = $question->status === 'active' ? 'pending' : 'active';

        DB::transaction(function () use ($question, $nextStatus): void {
            $question->update(['status' => $nextStatus]);

            if ($nextStatus === 'active') {
                $this->payQuestionEarning($question);
            }
        });

        $message = $nextStatus === 'active'
            ? 'Question approved successfully.'
            : 'Question moved back to pending successfully.';

        $this->dispatch('questionStatusUpdated', message: $message);
        $this->resetPage();
    }


    private function payQuestionEarning(Question $question): void
    {
        if ($question->is_paid || ! $question->user?->isTeacher()) {
            return;
        }

        $wallet = Wallet::query()->firstOrCreate(
            ['user_id' => $question->user_id],
            ['credit_balance' => 0, 'reward_balance' => 0]
        );

        $wallet->increment('reward_balance', self::QUESTION_EARNING_AMOUNT);
        $question->update(['is_paid' => true]);
    }

    public function render()
    {
        $user = auth()->user();

        $baseQuery = Question::query()
            ->when($user->isTeacher(), fn ($q) => $q->where('user_id', $user->id));

        $allQuestionsCount = (clone $baseQuery)->count();
        $mineQuestionsCount = (clone $baseQuery)->where('user_id', $user->id)->count();
        $publishedQuestionsCount = (clone $baseQuery)->where('status', 'active')->count();
        $pendingQuestionsCount = (clone $baseQuery)->where('status', 'pending')->count();

        $questions = Question::with('subject', 'topic', 'user')
            ->when($user->isTeacher(), fn ($q) => $q->where('user_id', $user->id))
            ->when($this->quickFilter === 'mine', fn ($q) => $q->where('user_id', $user->id))
            ->when($this->quickFilter === 'published', fn ($q) => $q->where('status', 'active'))
            ->when($this->quickFilter === 'pending', fn ($q) => $q->where('status', 'pending'))
            ->when($this->search, function ($q) {
                $search = '%'.$this->search.'%';
                $q->where(function ($query) use ($search): void {
                    $query->where('title', 'like', $search)
                        ->orWhereRelation('subject', 'name', 'like', $search)
                        ->orWhereRelation('topic', 'name', 'like', $search);
                });
            })
            ->when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
            ->when($this->topicId, fn ($q) => $q->where('topic_id', $this->topicId))
            ->when($this->questionTypeFilter, fn ($q) => $q->where('question_type', $this->questionTypeFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions', [
            'questions' => $questions,
            'subjects' => Subject::orderBy('name')->get(),
            'topics' => Topic::when($this->subjectId, fn ($q) => $q->where('subject_id', $this->subjectId))
                ->orderBy('name')
                ->get(),
            'allQuestionsCount' => $allQuestionsCount,
            'mineQuestionsCount' => $mineQuestionsCount,
            'publishedQuestionsCount' => $publishedQuestionsCount,
            'pendingQuestionsCount' => $pendingQuestionsCount,
        ])->layout('layouts.app', ['title' => 'All Questions']);
    }
}

<?php

namespace App\Livewire;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Questions extends Component
{
    use AuthorizesRequests;
    use InteractsWithFluxToasts;
    use WithPagination;

    private const QUESTION_EARNING_AMOUNT = 10;

    public string $search = '';

    public string $academicClassId = '';

    public string $subjectId = '';

    public string $chapterId = '';

    public string $topicId = '';

    public string $questionTypeFilter = '';

    public string $quickFilter = 'all';

    /** @var array<int> */
    public array $selectedQuestionIds = [];

    public bool $selectPage = false;

    public bool $showQuestionModal = false;

    public ?Question $selectedQuestion = null;

    public bool $showConfirmationModal = false;

    public string $confirmationAction = '';

    /** @var array<int> */
    public array $confirmationQuestionIds = [];

    public string $confirmationTitle = '';

    public string $confirmationDescription = '';

    public string $confirmationButton = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingAcademicClassId(): void
    {
        $this->subjectId = '';
        $this->chapterId = '';
        $this->topicId = '';
        $this->resetPage();
    }

    public function updatingSubjectId(): void
    {
        $this->chapterId = '';
        $this->topicId = '';
        $this->resetPage();
    }

    public function updatingChapterId(): void
    {
        $this->topicId = '';
        $this->resetPage();
    }

    public function updatingTopicId(): void
    {
        $this->resetPage();
    }

    public function updatingQuestionTypeFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSelectPage(bool $selectPage): void
    {
        $this->selectedQuestionIds = $selectPage
            ? $this->filteredQuestionQuery()->pluck('id')->map(fn (int $id): int => $id)->all()
            : [];
    }

    public function setQuickFilter(string $filter): void
    {
        $this->quickFilter = $filter;
        $this->selectedQuestionIds = [];
        $this->selectPage = false;
        $this->resetPage();
    }

    public function openQuestionModal(int $id): void
    {
        $this->selectedQuestion = $this->visibleQuestionQuery(true)
            ->with(['academicClass', 'subject', 'chapter', 'topic', 'user', 'tags'])
            ->findOrFail($id);
        $this->showQuestionModal = true;
    }

    public function confirmAction(string $action, ?int $id = null): void
    {
        $questionIds = $id === null ? $this->selectedQuestionIds : [$id];

        if ($questionIds === []) {
            $this->toastWarning('Select at least one question first.');

            return;
        }

        $this->confirmationAction = $action;
        $this->confirmationQuestionIds = array_map('intval', $questionIds);

        [$this->confirmationTitle, $this->confirmationDescription, $this->confirmationButton] = match ($action) {
            'approve' => ['Approve question?', 'The question will be published and become available to students.', 'Approve'],
            'unapprove' => ['Move question to pending?', 'The question will no longer be published and will require review again.', 'Move to pending'],
            'reject' => ['Reject question?', 'The question will be marked as rejected and remain unavailable to students.', 'Reject'],
            'restore' => ['Restore question?', 'The question will be moved out of the trash.', 'Restore'],
            'force_delete' => ['Permanently delete question?', 'This cannot be undone. The question and its tag/category links will be removed forever.', 'Delete permanently'],
            default => ['Move question to trash?', 'The question can be restored later from the trash.', 'Move to trash'],
        };

        $this->showConfirmationModal = true;
    }

    public function executeConfirmation(): void
    {
        $questionIds = $this->confirmationQuestionIds;

        match ($this->confirmationAction) {
            'approve' => $this->updateQuestionStatus($questionIds, 'active'),
            'unapprove' => $this->updateQuestionStatus($questionIds, 'pending'),
            'reject' => $this->updateQuestionStatus($questionIds, 'inactive'),
            'restore' => $this->restoreQuestions($questionIds),
            'force_delete' => $this->forceDeleteQuestions($questionIds),
            default => $this->trashQuestions($questionIds),
        };

        $this->showConfirmationModal = false;
        $this->confirmationQuestionIds = [];
        $this->selectedQuestionIds = [];
        $this->selectPage = false;
        $this->selectedQuestion = null;
        $this->showQuestionModal = false;
        $this->resetPage();
    }

    /**
     * Backwards-compatible single-question delete action.
     */
    public function deleteQuestion(int $id): void
    {
        $this->trashQuestions([$id]);
        $this->resetPage();
    }

    /**
     * Backwards-compatible publish toggle action.
     */
    public function toggleQuestionStatus(int $id): void
    {
        $question = $this->visibleQuestionQuery()->findOrFail($id);
        $this->updateQuestionStatus([$id], $question->status === 'active' ? 'pending' : 'active');
        $this->resetPage();
    }

    /** @param array<int> $questionIds */
    private function trashQuestions(array $questionIds): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.delete'), 403);

        $this->visibleQuestionQuery()->whereKey($questionIds)->get()->each->delete();
        $this->toastSuccess(count($questionIds) === 1 ? 'Question moved to trash.' : 'Selected questions moved to trash.');
    }

    /** @param array<int> $questionIds */
    private function restoreQuestions(array $questionIds): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.delete'), 403);

        $this->visibleQuestionQuery(true)->onlyTrashed()->whereKey($questionIds)->get()->each->restore();
        $this->toastSuccess(count($questionIds) === 1 ? 'Question restored successfully.' : 'Selected questions restored successfully.');
    }

    /** @param array<int> $questionIds */
    private function forceDeleteQuestions(array $questionIds): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.delete'), 403);

        $questions = $this->visibleQuestionQuery(true)->onlyTrashed()->with(['tags', 'examCategories'])->whereKey($questionIds)->get();

        DB::transaction(function () use ($questions): void {
            $questions->each(function (Question $question): void {
                $question->tags()->detach();
                $question->examCategories()->detach();
                $question->forceDelete();
            });
        });

        $this->toastSuccess(count($questionIds) === 1 ? 'Question deleted permanently.' : 'Selected questions deleted permanently.');
    }

    /** @param array<int> $questionIds */
    private function updateQuestionStatus(array $questionIds, string $status): void
    {
        abort_unless(auth()->user()?->hasPermission('questions.publish'), 403);

        $questions = $this->visibleQuestionQuery()->with('user')->whereKey($questionIds)->get();

        DB::transaction(function () use ($questions, $status): void {
            $questions->each(function (Question $question) use ($status): void {
                $question->update(['status' => $status]);

                if ($status === 'active') {
                    $this->payQuestionEarning($question);
                }
            });
        });

        $message = match ($status) {
            'active' => 'Question approved successfully.',
            'pending' => 'Question moved to pending successfully.',
            default => 'Question rejected successfully.',
        };

        $this->toastSuccess($message);
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

    private function visibleQuestionQuery(bool $withTrashed = false): Builder
    {
        $user = auth()->user();
        $query = Question::query();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->when($user?->isTeacher(), fn (Builder $query): Builder => $query->where('user_id', $user->id));
    }

    private function filteredQuestionQuery(): Builder
    {
        return $this->visibleQuestionQuery($this->quickFilter === 'trash')
            ->when($this->quickFilter === 'trash', fn (Builder $query): Builder => $query->onlyTrashed())
            ->when($this->quickFilter === 'mine', fn (Builder $query): Builder => $query->where('user_id', auth()->id()))
            ->when($this->quickFilter === 'published', fn (Builder $query): Builder => $query->where('status', 'active'))
            ->when($this->quickFilter === 'pending', fn (Builder $query): Builder => $query->where('status', 'pending'))
            ->when($this->quickFilter === 'rejected', fn (Builder $query): Builder => $query->where('status', 'inactive'))
            ->when($this->search !== '', function (Builder $query): void {
                $search = '%'.$this->search.'%';
                $query->where(fn (Builder $searchQuery): Builder => $searchQuery
                    ->where('title', 'like', $search)
                    ->orWhereRelation('subject', 'name', 'like', $search)
                    ->orWhereRelation('chapter', 'name', 'like', $search)
                    ->orWhereRelation('topic', 'name', 'like', $search));
            })
            ->when($this->academicClassId !== '', fn (Builder $query): Builder => $query->where('academic_class_id', $this->academicClassId))
            ->when($this->subjectId !== '', fn (Builder $query): Builder => $query->where('subject_id', $this->subjectId))
            ->when($this->chapterId !== '', fn (Builder $query): Builder => $query->where('chapter_id', $this->chapterId))
            ->when($this->topicId !== '', fn (Builder $query): Builder => $query->where('topic_id', $this->topicId))
            ->when($this->questionTypeFilter !== '', fn (Builder $query): Builder => $query->where('question_type', $this->questionTypeFilter));
    }

    public function render()
    {
        $baseQuery = $this->visibleQuestionQuery();

        $questions = $this->filteredQuestionQuery()
            ->with(['academicClass', 'subject', 'chapter', 'topic', 'user'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.questions', [
            'questions' => $questions,
            'academicClasses' => AcademicClass::query()->orderBy('order_sequence')->orderBy('name')->get(),
            'subjects' => Subject::query()->when($this->academicClassId !== '', fn (Builder $query): Builder => $query->where('academic_class_id', $this->academicClassId))->orderBy('name')->get(),
            'chapters' => Chapter::query()
                ->when($this->subjectId !== '', fn (Builder $query): Builder => $query->where('subject_id', $this->subjectId))
                ->when($this->subjectId === '' && $this->academicClassId !== '', fn (Builder $query): Builder => $query->whereRelation('subject', 'academic_class_id', $this->academicClassId))
                ->orderBy('order_sequence')
                ->orderBy('name')
                ->get(),
            'topics' => Topic::query()
                ->when($this->chapterId !== '', fn (Builder $query): Builder => $query->where('chapter_id', $this->chapterId))
                ->when($this->chapterId === '' && $this->subjectId !== '', fn (Builder $query): Builder => $query->whereRelation('chapter', 'subject_id', $this->subjectId))
                ->when($this->chapterId === '' && $this->subjectId === '' && $this->academicClassId !== '', fn (Builder $query): Builder => $query->whereRelation('chapter.subject', 'academic_class_id', $this->academicClassId))
                ->orderBy('order_sequence')
                ->orderBy('name')
                ->get(),
            'allQuestionsCount' => (clone $baseQuery)->count(),
            'mineQuestionsCount' => (clone $baseQuery)->where('user_id', auth()->id())->count(),
            'publishedQuestionsCount' => (clone $baseQuery)->where('status', 'active')->count(),
            'pendingQuestionsCount' => (clone $baseQuery)->where('status', 'pending')->count(),
            'rejectedQuestionsCount' => (clone $baseQuery)->where('status', 'inactive')->count(),
            'trashedQuestionsCount' => (clone $this->visibleQuestionQuery(true))->onlyTrashed()->count(),
        ])->layout('layouts.app', ['title' => 'All Questions']);
    }
}

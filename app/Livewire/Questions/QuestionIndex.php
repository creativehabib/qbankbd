<?php

namespace App\Livewire\Questions;

use App\Models\Chapter;
use App\Models\ExamCategory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionIndex extends Component
{
    use WithPagination;

    public string $search = '';

    public ?int $subjectFilter = null;

    public ?int $topicFilter = null;

    public bool $showModal = false;

    public ?int $editingQuestionId = null;

    public ?int $subject_id = null;

    public ?int $chapter_id = null;

    public ?int $topic_id = null;

    public string $title = '';

    public ?string $description = null;

    public string $difficulty = 'easy';

    public string $question_type = 'mcq';

    public float $marks = 1;

    public string $status = 'active';

    public bool $is_premium = false;

    public ?string $slug = null;

    /** @var array<int> */
    public array $exam_category_ids = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSubjectFilter(): void
    {
        $this->topicFilter = null;
        $this->resetPage();
    }

    public function updatedTopicFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSubjectId(): void
    {
        $this->chapter_id = null;
        $this->topic_id = null;
    }

    public function updatedChapterId(): void
    {
        $this->topic_id = null;
    }

    public function openModal(): void
    {
        $this->resetForm();
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
    }

    public function editQuestion(int $id): void
    {
        $question = Question::query()->findOrFail($id);

        $this->editingQuestionId = $question->id;
        $this->subject_id = $question->subject_id;
        $this->chapter_id = $question->chapter_id;
        $this->topic_id = $question->topic_id;
        $this->title = $question->title;
        $this->slug = $question->slug;
        $this->description = $question->description;
        $this->difficulty = $question->difficulty;
        $this->question_type = $question->question_type;
        $this->marks = (float) $question->marks;
        $this->status = $question->status;
        $this->is_premium = (bool) $question->is_premium;
        $this->exam_category_ids = $question->examCategories()->pluck('exam_categories.id')->map(fn ($id) => (int) $id)->all();

        $this->resetValidation();
        $this->showModal = true;
    }

    public function saveQuestion(): void
    {
        $validated = $this->validate([
            'subject_id' => ['required', 'exists:subjects,id'],
            'chapter_id' => ['nullable', 'exists:chapters,id'],
            'topic_id' => ['nullable', 'exists:topics,id'],
            'title' => ['required', 'string'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'question_type' => ['required', 'in:mcq,cq,short,written'],
            'marks' => ['required', 'numeric', 'min:0.25'],
            'status' => ['required', 'in:active,pending,inactive'],
            'is_premium' => ['boolean'],
            'exam_category_ids' => ['array'],
            'exam_category_ids.*' => ['exists:exam_categories,id'],
        ]);

        $baseSlug = Str::slug($this->slug ?: $this->title);
        $validatedSlug = $this->ensureUniqueSlug($baseSlug);

        $payload = [
            'user_id' => auth()->id(),
            'subject_id' => $validated['subject_id'],
            'chapter_id' => $validated['chapter_id'],
            'topic_id' => $validated['topic_id'],
            'title' => $validated['title'],
            'slug' => $validatedSlug,
            'description' => $validated['description'],
            'difficulty' => $validated['difficulty'],
            'question_type' => $validated['question_type'],
            'marks' => $validated['marks'],
            'status' => $validated['status'],
            'is_premium' => $validated['is_premium'],
            'academic_class_id' => Subject::query()->find($validated['subject_id'])?->academic_class_id,
        ];

        if ($this->editingQuestionId !== null) {
            Question::query()->whereKey($this->editingQuestionId)->update($payload);
            $question = Question::query()->findOrFail($this->editingQuestionId);
            $message = 'Question updated successfully.';
        } else {
            $payload['uuid'] = (string) Str::uuid();
            $question = Question::query()->create($payload);
            $message = 'Question created successfully.';
        }

        $question->examCategories()->sync($validated['exam_category_ids'] ?? []);

        $this->showModal = false;
        $this->dispatch('entity-saved', message: $message);
        $this->resetForm();
    }

    public function deleteQuestion(int $id): void
    {
        $question = Question::query()->findOrFail($id);
        $question->examCategories()->detach();
        $question->delete();

        $this->dispatch('entity-deleted', message: 'Question deleted successfully.');
        $this->resetPage();
    }

    public function render(): View
    {
        $questions = Question::query()
            ->with(['subject', 'topic'])
            ->when($this->search, function ($query): void {
                $searchTerm = '%'.$this->search.'%';
                $query->where(function ($innerQuery) use ($searchTerm): void {
                    $innerQuery->where('title', 'like', $searchTerm)
                        ->orWhere('slug', 'like', $searchTerm)
                        ->orWhereRelation('subject', 'name', 'like', $searchTerm)
                        ->orWhereRelation('topic', 'name', 'like', $searchTerm);
                });
            })
            ->when($this->subjectFilter, fn ($query) => $query->where('subject_id', $this->subjectFilter))
            ->when($this->topicFilter, fn ($query) => $query->where('topic_id', $this->topicFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.questions.question-index', [
            'questions' => $questions,
            'subjects' => Subject::query()->orderBy('name')->get(),
            'chapters' => Chapter::query()->when($this->subject_id, fn ($query) => $query->where('subject_id', $this->subject_id))->orderBy('name')->get(),
            'topics' => Topic::query()->when($this->chapter_id, fn ($query) => $query->where('chapter_id', $this->chapter_id))->orderBy('name')->get(),
            'filterTopics' => Topic::query()->when($this->subjectFilter, fn ($query) => $query->where('subject_id', $this->subjectFilter))->orderBy('name')->get(),
            'examCategories' => ExamCategory::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Manage Questions']);
    }

    private function resetForm(): void
    {
        $this->editingQuestionId = null;
        $this->subject_id = null;
        $this->chapter_id = null;
        $this->topic_id = null;
        $this->title = '';
        $this->slug = null;
        $this->description = null;
        $this->difficulty = 'easy';
        $this->question_type = 'mcq';
        $this->marks = 1;
        $this->status = 'active';
        $this->is_premium = false;
        $this->exam_category_ids = [];
    }

    private function ensureUniqueSlug(string $baseSlug): string
    {
        $slugBase = $baseSlug !== '' ? $baseSlug : Str::slug(Str::random(8));
        $slug = $slugBase;
        $counter = 1;

        while (Question::query()
            ->where('slug', $slug)
            ->when($this->editingQuestionId, fn ($query) => $query->where('id', '!=', $this->editingQuestionId))
            ->exists()) {
            $slug = $slugBase.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}

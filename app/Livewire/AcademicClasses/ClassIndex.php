<?php

namespace App\Livewire\AcademicClasses;

use App\Models\AcademicClass;
use App\Models\Chapter;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class ClassIndex extends Component
{
    public string $classSearch = '';

    public string $subjectSearch = '';

    public string $chapterSearch = '';

    public string $topicSearch = '';

    public ?int $editingClassId = null;

    public string $class_name = '';

    public ?string $class_description = null;

    public bool $class_is_active = true;

    public bool $class_is_premium = false;

    public ?int $editingSubjectId = null;

    public ?int $subject_academic_class_id = null;

    public string $subject_name = '';

    public ?string $subject_code = null;

    public ?string $subject_description = null;

    public bool $subject_is_active = true;

    public bool $subject_is_premium = false;

    public ?int $editingChapterId = null;

    public ?int $chapter_subject_id = null;

    public string $chapter_name = '';

    public ?string $chapter_no = null;

    public ?string $chapter_description = null;

    public bool $chapter_is_active = true;

    public bool $chapter_is_premium = false;

    public ?int $editingTopicId = null;

    public ?int $topic_chapter_id = null;

    public string $topic_name = '';

    public ?string $topic_description = null;

    public bool $topic_is_active = true;

    public bool $topic_is_premium = false;

    public function openClassModal(): void
    {
        $this->resetClassForm();
        $this->resetValidation();
        $this->dispatch('open-class-modal');
    }

    public function editClass(int $id): void
    {
        $academicClass = AcademicClass::query()->findOrFail($id);

        $this->editingClassId = $academicClass->id;
        $this->class_name = $academicClass->name;
        $this->class_description = $academicClass->description;
        $this->class_is_active = (bool) $academicClass->is_active;
        $this->class_is_premium = (bool) $academicClass->is_premium;

        $this->resetValidation();
        $this->dispatch('open-class-modal');
    }

    public function saveClass(): void
    {
        $validated = $this->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'class_description' => ['nullable', 'string'],
            'class_is_active' => ['boolean'],
            'class_is_premium' => ['boolean'],
        ]);

        $payload = [
            'name' => $validated['class_name'],
            'slug' => $this->uniqueSlug(AcademicClass::class, $validated['class_name'], $this->editingClassId),
            'description' => $validated['class_description'],
            'is_active' => $validated['class_is_active'],
            'is_premium' => $validated['class_is_premium'],
        ];

        if ($this->editingClassId !== null) {
            AcademicClass::query()->whereKey($this->editingClassId)->update($payload);
            $message = 'Academic class updated successfully.';
        } else {
            $payload['uuid'] = (string) Str::uuid();
            $payload['order_sequence'] = (AcademicClass::query()->max('order_sequence') ?? 0) + 1;
            AcademicClass::query()->create($payload);
            $message = 'Academic class created successfully.';
        }

        $this->dispatch('close-class-modal');
        $this->dispatch('entity-saved', message: $message);
        $this->resetClassForm();
    }

    public function deleteClass(int $id): void
    {
        AcademicClass::query()->findOrFail($id)->delete();
        $this->dispatch('entity-deleted', message: 'Academic class deleted successfully.');
    }

    public function openSubjectModal(): void
    {
        $this->resetSubjectForm();
        $this->resetValidation();
        $this->dispatch('open-subject-modal');
    }

    public function editSubject(int $id): void
    {
        $subject = Subject::query()->findOrFail($id);

        $this->editingSubjectId = $subject->id;
        $this->subject_academic_class_id = $subject->academic_class_id;
        $this->subject_name = $subject->name;
        $this->subject_code = $subject->subject_code;
        $this->subject_description = $subject->description;
        $this->subject_is_active = (bool) $subject->is_active;
        $this->subject_is_premium = (bool) $subject->is_premium;

        $this->resetValidation();
        $this->dispatch('open-subject-modal');
    }

    public function saveSubject(): void
    {
        $validated = $this->validate([
            'subject_academic_class_id' => ['required', 'exists:academic_classes,id'],
            'subject_name' => ['required', 'string', 'max:255'],
            'subject_code' => ['nullable', 'string', 'max:50'],
            'subject_description' => ['nullable', 'string'],
            'subject_is_active' => ['boolean'],
            'subject_is_premium' => ['boolean'],
        ]);

        $payload = [
            'academic_class_id' => $validated['subject_academic_class_id'],
            'name' => $validated['subject_name'],
            'subject_code' => $validated['subject_code'],
            'slug' => $this->uniqueSlug(Subject::class, $validated['subject_name'], $this->editingSubjectId),
            'description' => $validated['subject_description'],
            'is_active' => $validated['subject_is_active'],
            'is_premium' => $validated['subject_is_premium'],
        ];

        if ($this->editingSubjectId !== null) {
            Subject::query()->whereKey($this->editingSubjectId)->update($payload);
            $message = 'Subject updated successfully.';
        } else {
            $payload['uuid'] = (string) Str::uuid();
            $payload['order_sequence'] = (Subject::query()->max('order_sequence') ?? 0) + 1;
            Subject::query()->create($payload);
            $message = 'Subject created successfully.';
        }

        $this->dispatch('close-subject-modal');
        $this->dispatch('entity-saved', message: $message);
        $this->resetSubjectForm();
    }

    public function deleteSubject(int $id): void
    {
        Subject::query()->findOrFail($id)->delete();
        $this->dispatch('entity-deleted', message: 'Subject deleted successfully.');
    }

    public function openChapterModal(): void
    {
        $this->resetChapterForm();
        $this->resetValidation();
        $this->dispatch('open-chapter-modal');
    }

    public function editChapter(int $id): void
    {
        $chapter = Chapter::query()->findOrFail($id);

        $this->editingChapterId = $chapter->id;
        $this->chapter_subject_id = $chapter->subject_id;
        $this->chapter_name = $chapter->name;
        $this->chapter_no = $chapter->chapter_no;
        $this->chapter_description = $chapter->description;
        $this->chapter_is_active = (bool) $chapter->is_active;
        $this->chapter_is_premium = (bool) $chapter->is_premium;

        $this->resetValidation();
        $this->dispatch('open-chapter-modal');
    }

    public function saveChapter(): void
    {
        $validated = $this->validate([
            'chapter_subject_id' => ['required', 'exists:subjects,id'],
            'chapter_name' => ['required', 'string', 'max:255'],
            'chapter_no' => ['nullable', 'string', 'max:50'],
            'chapter_description' => ['nullable', 'string'],
            'chapter_is_active' => ['boolean'],
            'chapter_is_premium' => ['boolean'],
        ]);

        $payload = [
            'subject_id' => $validated['chapter_subject_id'],
            'name' => $validated['chapter_name'],
            'chapter_no' => $validated['chapter_no'],
            'slug' => $this->uniqueSlug(Chapter::class, $validated['chapter_name'], $this->editingChapterId),
            'description' => $validated['chapter_description'],
            'is_active' => $validated['chapter_is_active'],
            'is_premium' => $validated['chapter_is_premium'],
        ];

        if ($this->editingChapterId !== null) {
            Chapter::query()->whereKey($this->editingChapterId)->update($payload);
            $message = 'Chapter updated successfully.';
        } else {
            $payload['uuid'] = (string) Str::uuid();
            $payload['order_sequence'] = (Chapter::query()->max('order_sequence') ?? 0) + 1;
            Chapter::query()->create($payload);
            $message = 'Chapter created successfully.';
        }

        $this->dispatch('close-chapter-modal');
        $this->dispatch('entity-saved', message: $message);
        $this->resetChapterForm();
    }

    public function deleteChapter(int $id): void
    {
        Chapter::query()->findOrFail($id)->delete();
        $this->dispatch('entity-deleted', message: 'Chapter deleted successfully.');
    }

    public function openTopicModal(): void
    {
        $this->resetTopicForm();
        $this->resetValidation();
        $this->dispatch('open-topic-modal');
    }

    public function editTopic(int $id): void
    {
        $topic = Topic::query()->findOrFail($id);

        $this->editingTopicId = $topic->id;
        $this->topic_chapter_id = $topic->chapter_id;
        $this->topic_name = $topic->name;
        $this->topic_description = $topic->description;
        $this->topic_is_active = (bool) $topic->is_active;
        $this->topic_is_premium = (bool) $topic->is_premium;

        $this->resetValidation();
        $this->dispatch('open-topic-modal');
    }

    public function saveTopic(): void
    {
        $validated = $this->validate([
            'topic_chapter_id' => ['required', 'exists:chapters,id'],
            'topic_name' => ['required', 'string', 'max:255'],
            'topic_description' => ['nullable', 'string'],
            'topic_is_active' => ['boolean'],
            'topic_is_premium' => ['boolean'],
        ]);

        $payload = [
            'chapter_id' => $validated['topic_chapter_id'],
            'name' => $validated['topic_name'],
            'slug' => $this->uniqueSlug(Topic::class, $validated['topic_name'], $this->editingTopicId),
            'description' => $validated['topic_description'],
            'is_active' => $validated['topic_is_active'],
            'is_premium' => $validated['topic_is_premium'],
        ];

        if ($this->editingTopicId !== null) {
            Topic::query()->whereKey($this->editingTopicId)->update($payload);
            $message = 'Topic updated successfully.';
        } else {
            $payload['uuid'] = (string) Str::uuid();
            $payload['order_sequence'] = (Topic::query()->max('order_sequence') ?? 0) + 1;
            Topic::query()->create($payload);
            $message = 'Topic created successfully.';
        }

        $this->dispatch('close-topic-modal');
        $this->dispatch('entity-saved', message: $message);
        $this->resetTopicForm();
    }

    public function deleteTopic(int $id): void
    {
        Topic::query()->findOrFail($id)->delete();
        $this->dispatch('entity-deleted', message: 'Topic deleted successfully.');
    }

    public function render(): View
    {
        return view('livewire.academic-classes.class-index', [
            'academicClasses' => AcademicClass::query()
                ->when($this->classSearch, fn ($query) => $query->where('name', 'like', '%'.$this->classSearch.'%'))
                ->latest()
                ->get(),
            'subjects' => Subject::query()
                ->with('academicClass')
                ->when($this->subjectSearch, function ($query): void {
                    $query->where('name', 'like', '%'.$this->subjectSearch.'%')
                        ->orWhere('subject_code', 'like', '%'.$this->subjectSearch.'%');
                })
                ->latest()
                ->get(),
            'chapters' => Chapter::query()
                ->with('subject')
                ->when($this->chapterSearch, fn ($query) => $query->where('name', 'like', '%'.$this->chapterSearch.'%'))
                ->latest()
                ->get(),
            'topics' => Topic::query()
                ->with('chapter.subject')
                ->when($this->topicSearch, fn ($query) => $query->where('name', 'like', '%'.$this->topicSearch.'%'))
                ->latest()
                ->get(),
            'allClasses' => AcademicClass::query()->orderBy('name')->get(),
            'allSubjects' => Subject::query()->orderBy('name')->get(),
            'allChapters' => Chapter::query()->orderBy('name')->get(),
        ])->layout('layouts.app', ['title' => 'Academic Content CRUD']);
    }

    private function resetClassForm(): void
    {
        $this->editingClassId = null;
        $this->class_name = '';
        $this->class_description = null;
        $this->class_is_active = true;
        $this->class_is_premium = false;
    }

    private function resetSubjectForm(): void
    {
        $this->editingSubjectId = null;
        $this->subject_academic_class_id = null;
        $this->subject_name = '';
        $this->subject_code = null;
        $this->subject_description = null;
        $this->subject_is_active = true;
        $this->subject_is_premium = false;
    }

    private function resetChapterForm(): void
    {
        $this->editingChapterId = null;
        $this->chapter_subject_id = null;
        $this->chapter_name = '';
        $this->chapter_no = null;
        $this->chapter_description = null;
        $this->chapter_is_active = true;
        $this->chapter_is_premium = false;
    }

    private function resetTopicForm(): void
    {
        $this->editingTopicId = null;
        $this->topic_chapter_id = null;
        $this->topic_name = '';
        $this->topic_description = null;
        $this->topic_is_active = true;
        $this->topic_is_premium = false;
    }

    private function uniqueSlug(string $modelClass, string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while ($modelClass::query()
            ->where('slug', $slug)
            ->when($ignoreId !== null, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}

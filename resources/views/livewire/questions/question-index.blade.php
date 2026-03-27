<div class="space-y-6">
    <div>
        <flux:heading size="xl">Questions</flux:heading>
        <flux:subheading>Question bank CRUD from a single page.</flux:subheading>
        <flux:separator class="my-6" />
    </div>

    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="mb-4 grid gap-3 md:grid-cols-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search question"
                   class="rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500" />

            <select wire:model.live="subjectFilter"
                    class="rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="topicFilter"
                    class="rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">All Topics</option>
                @foreach($filterTopics as $topic)
                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                @endforeach
            </select>

            <button wire:click="openModal" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 transition-colors">
                New Question
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                <tr class="border-b dark:border-gray-700">
                    <th class="py-2 text-left">Title</th>
                    <th class="py-2 text-left">Subject/Topic</th>
                    <th class="py-2 text-left">Type</th>
                    <th class="py-2 text-left">Marks</th>
                    <th class="py-2 text-left">Status</th>
                    <th class="py-2 text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($questions as $question)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="py-3">
                            <p class="font-medium text-gray-900 dark:text-gray-100">{{ $question->title }}</p>
                            <p class="text-xs text-gray-500">/{{ $question->slug }}</p>
                        </td>
                        <td class="py-3 text-gray-600 dark:text-gray-300">
                            {{ $question->subject?->name }}
                            @if($question->topic)
                                <span class="text-xs text-gray-400">/ {{ $question->topic->name }}</span>
                            @endif
                        </td>
                        <td class="py-3 uppercase">{{ $question->question_type }}</td>
                        <td class="py-3">{{ number_format((float) $question->marks, 2) }}</td>
                        <td class="py-3">
                            <span class="rounded-full px-2 py-1 text-xs font-medium {{ $question->status === 'active' ? 'bg-green-100 text-green-700' : ($question->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                {{ ucfirst($question->status) }}
                            </span>
                        </td>
                        <td class="space-x-2 py-3 text-right">
                            <button wire:click="editQuestion({{ $question->id }})" class="text-indigo-600 hover:text-indigo-800">Edit</button>
                            <button wire:click="deleteQuestion({{ $question->id }})" class="text-red-600 hover:text-red-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500">No questions found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($questions->hasPages())
            <div class="pt-4">{{ $questions->links() }}</div>
        @endif
    </section>

    <div x-data="{ open: @entangle('showModal') }" x-show="open" style="display:none" class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true" role="dialog">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="open" class="fixed inset-0 bg-black/40" @click="open = false"></div>

            <div x-show="open" class="relative z-10 w-full max-w-3xl rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b px-6 py-4 dark:border-gray-700">
                    <h3 class="text-lg font-semibold">{{ $editingQuestionId ? 'Edit Question' : 'Create Question' }}</h3>
                </div>

                <form wire:submit="saveQuestion" class="space-y-4 p-6">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm">Subject *</label>
                            <select wire:model="subject_id" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="">Select subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm">Chapter</label>
                            <select wire:model="chapter_id" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="">Select chapter</option>
                                @foreach($chapters as $chapter)
                                    <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                                @endforeach
                            </select>
                            @error('chapter_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm">Topic</label>
                            <select wire:model="topic_id" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="">Select topic</option>
                                @foreach($topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                            @error('topic_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm">Slug (optional)</label>
                            <input wire:model="slug" type="text" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700" placeholder="auto from title" />
                            @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm">Question Title *</label>
                        <textarea wire:model="title" rows="3" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700"></textarea>
                        @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm">Description</label>
                        <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700"></textarea>
                    </div>

                    <div class="grid gap-4 md:grid-cols-4">
                        <div>
                            <label class="mb-1 block text-sm">Difficulty</label>
                            <select wire:model="difficulty" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="easy">Easy</option>
                                <option value="medium">Medium</option>
                                <option value="hard">Hard</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm">Type</label>
                            <select wire:model="question_type" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="mcq">MCQ</option>
                                <option value="cq">CQ</option>
                                <option value="short">Short</option>
                                <option value="written">Written</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-1 block text-sm">Marks</label>
                            <input wire:model="marks" type="number" step="0.25" min="0.25" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700" />
                            @error('marks') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm">Status</label>
                            <select wire:model="status" class="w-full rounded-lg border-gray-300 text-sm dark:border-gray-600 dark:bg-gray-700">
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm">Target Exam Categories</label>
                        <div class="grid grid-cols-2 gap-2 rounded-lg border border-gray-200 p-3 dark:border-gray-700 md:grid-cols-3">
                            @foreach($examCategories as $examCategory)
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="checkbox" wire:model="exam_category_ids" value="{{ $examCategory->id }}" class="rounded border-gray-300 text-indigo-600" />
                                    <span>{{ $examCategory->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" wire:model="is_premium" class="rounded border-gray-300 text-indigo-600" />
                        Premium Question
                    </label>

                    <div class="flex justify-end gap-2 border-t pt-4 dark:border-gray-700">
                        <button type="button" @click="open = false" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">Cancel</button>
                        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

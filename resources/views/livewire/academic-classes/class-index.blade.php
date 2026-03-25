<div class="space-y-8">
    <div>
        <flux:heading size="xl">Academic Structure CRUD</flux:heading>
        <flux:subheading>একই পেইজ থেকে Academic Class, Subject, Chapter এবং Topic ম্যানেজ করুন।</flux:subheading>
        <flux:separator class="my-6" />
    </div>

    @if (session('status'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-3 text-lg font-semibold">Academic Class</h2>
            <form wire:submit="saveAcademicClass" class="space-y-3">
                <input wire:model="class_name" type="text" placeholder="Class name" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('class_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <textarea wire:model="class_description" placeholder="Description" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"></textarea>

                <div class="flex items-center gap-4 text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="class_is_active"> Active</label>
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="class_is_premium"> Premium</label>
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-3 py-2 text-white">
                    {{ $editingClassId ? 'Update Class' : 'Create Class' }}
                </button>
            </form>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left"><th>Name</th><th>Status</th><th class="text-right">Action</th></tr></thead>
                    <tbody>
                    @forelse($academicClasses as $academicClass)
                        <tr class="border-t border-zinc-100 dark:border-zinc-700">
                            <td class="py-2">{{ $academicClass->name }}</td>
                            <td>{{ $academicClass->is_active ? 'Active' : 'Inactive' }}</td>
                            <td class="py-2 text-right space-x-2">
                                <button wire:click="editAcademicClass({{ $academicClass->id }})" class="text-indigo-600">Edit</button>
                                <button wire:click="deleteAcademicClass({{ $academicClass->id }})" class="text-red-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-3 text-center text-zinc-500">No class found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-3 text-lg font-semibold">Subject</h2>
            <form wire:submit="saveSubject" class="space-y-3">
                <select wire:model="subject_academic_class_id" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">Select class</option>
                    @foreach($academicClasses as $academicClass)
                        <option value="{{ $academicClass->id }}">{{ $academicClass->name }}</option>
                    @endforeach
                </select>
                @error('subject_academic_class_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <input wire:model="subject_name" type="text" placeholder="Subject name" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('subject_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <input wire:model="subject_code" type="text" placeholder="Subject code" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />

                <textarea wire:model="subject_description" placeholder="Description" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"></textarea>

                <div class="flex items-center gap-4 text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="subject_is_active"> Active</label>
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="subject_is_premium"> Premium</label>
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-3 py-2 text-white">
                    {{ $editingSubjectId ? 'Update Subject' : 'Create Subject' }}
                </button>
            </form>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left"><th>Name</th><th>Class</th><th class="text-right">Action</th></tr></thead>
                    <tbody>
                    @forelse($subjects as $subject)
                        <tr class="border-t border-zinc-100 dark:border-zinc-700">
                            <td class="py-2">{{ $subject->name }}</td>
                            <td>{{ $subject->academicClass?->name }}</td>
                            <td class="py-2 text-right space-x-2">
                                <button wire:click="editSubject({{ $subject->id }})" class="text-indigo-600">Edit</button>
                                <button wire:click="deleteSubject({{ $subject->id }})" class="text-red-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-3 text-center text-zinc-500">No subject found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-3 text-lg font-semibold">Chapter</h2>
            <form wire:submit="saveChapter" class="space-y-3">
                <select wire:model="chapter_subject_id" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">Select subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
                @error('chapter_subject_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <input wire:model="chapter_name" type="text" placeholder="Chapter name" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('chapter_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <input wire:model="chapter_no" type="text" placeholder="Chapter no" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />
                <textarea wire:model="chapter_description" placeholder="Description" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"></textarea>

                <div class="flex items-center gap-4 text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="chapter_is_active"> Active</label>
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="chapter_is_premium"> Premium</label>
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-3 py-2 text-white">
                    {{ $editingChapterId ? 'Update Chapter' : 'Create Chapter' }}
                </button>
            </form>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left"><th>Name</th><th>Subject</th><th class="text-right">Action</th></tr></thead>
                    <tbody>
                    @forelse($chapters as $chapter)
                        <tr class="border-t border-zinc-100 dark:border-zinc-700">
                            <td class="py-2">{{ $chapter->name }}</td>
                            <td>{{ $chapter->subject?->name }}</td>
                            <td class="py-2 text-right space-x-2">
                                <button wire:click="editChapter({{ $chapter->id }})" class="text-indigo-600">Edit</button>
                                <button wire:click="deleteChapter({{ $chapter->id }})" class="text-red-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-3 text-center text-zinc-500">No chapter found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-lg border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="mb-3 text-lg font-semibold">Topic</h2>
            <form wire:submit="saveTopic" class="space-y-3">
                <select wire:model="topic_chapter_id" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800">
                    <option value="">Select chapter</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                    @endforeach
                </select>
                @error('topic_chapter_id') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <input wire:model="topic_name" type="text" placeholder="Topic name" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800" />
                @error('topic_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                <textarea wire:model="topic_description" placeholder="Description" class="w-full rounded border-zinc-300 dark:border-zinc-700 dark:bg-zinc-800"></textarea>

                <div class="flex items-center gap-4 text-sm">
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="topic_is_active"> Active</label>
                    <label class="flex items-center gap-2"><input type="checkbox" wire:model="topic_is_premium"> Premium</label>
                </div>

                <button type="submit" class="rounded bg-indigo-600 px-3 py-2 text-white">
                    {{ $editingTopicId ? 'Update Topic' : 'Create Topic' }}
                </button>
            </form>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead><tr class="text-left"><th>Name</th><th>Chapter</th><th class="text-right">Action</th></tr></thead>
                    <tbody>
                    @forelse($topics as $topic)
                        <tr class="border-t border-zinc-100 dark:border-zinc-700">
                            <td class="py-2">{{ $topic->name }}</td>
                            <td>{{ $topic->chapter?->name }}</td>
                            <td class="py-2 text-right space-x-2">
                                <button wire:click="editTopic({{ $topic->id }})" class="text-indigo-600">Edit</button>
                                <button wire:click="deleteTopic({{ $topic->id }})" class="text-red-600">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="py-3 text-center text-zinc-500">No topic found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

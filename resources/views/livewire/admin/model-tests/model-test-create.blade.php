<div>
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create Model Test</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Add a new time-bound model test</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.model-tests.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-zinc-700 border border-zinc-300 shadow-sm transition hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-700">
                Cancel
            </a>
            <button type="button" wire:click="save" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                Save Model Test
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Settings Panel --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-4">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Test Settings</h3>
                
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Title</label>
                    <input type="text" wire:model="title" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. 45th BCS Model Test 1">
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Duration (Minutes)</label>
                    <input type="number" wire:model="duration_minutes" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                    @error('duration_minutes') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Negative Mark Weight</label>
                    <select wire:model="negative_mark_weight" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="0">No Negative Marking</option>
                        <option value="0.25">0.25 (1/4th)</option>
                        <option value="0.50">0.50 (1/2)</option>
                    </select>
                    @error('negative_mark_weight') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_published" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Publish Immediately</span>
                    </label>
                </div>
                
                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-zinc-600 dark:text-zinc-400">Selected Questions:</span>
                        <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ count($selectedQuestions) }}</span>
                    </div>
                    @error('selectedQuestions') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Question Selection Panel --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <select wire:model.live="class_id" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white text-sm">
                            <option value="">All Categories/Classes</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="subject_id" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white text-sm">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input type="text" wire:model.live.debounce.500ms="search" class="w-full rounded-lg border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white text-sm" placeholder="Search questions...">
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($questions as $question)
                        @php
                            $isSelected = in_array($question->id, $selectedQuestions);
                        @endphp
                        <div class="flex items-start gap-3 p-3 rounded-lg border {{ $isSelected ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50' }} transition cursor-pointer" wire:click="toggleQuestion({{ $question->id }})">
                            <div class="mt-1">
                                <input type="checkbox" @checked($isSelected) class="w-5 h-5 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 pointer-events-none">
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 leading-tight">
                                    {!! strip_tags($question->title) !!}
                                </div>
                                <div class="mt-1 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>{{ $question->academicClass?->name }}</span> • 
                                    <span>{{ $question->subject?->name }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-zinc-500">
                            No questions found.
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-4">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

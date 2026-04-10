<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
    @php
        $currentUser = auth()->user();
        $canCreateQuestion = $currentUser?->hasPermission('questions.create');
        $tabClass = 'text-sm hover:text-indigo-600 transition-colors';
        $activeTabClass = 'text-indigo-600 font-semibold';
    @endphp
    <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex flex-wrap items-center gap-2 text-gray-600 dark:text-gray-300">
                    <button wire:click="setQuickFilter('all')" class="{{ $quickFilter === 'all' ? $activeTabClass : $tabClass }}">
                        All ({{ $allQuestionsCount }})
                    </button>
                    <span>|</span>
                    <button wire:click="setQuickFilter('mine')" class="{{ $quickFilter === 'mine' ? $activeTabClass : $tabClass }}">
                        Mine ({{ $mineQuestionsCount }})
                    </button>
                    <span>|</span>
                    <button wire:click="setQuickFilter('published')" class="{{ $quickFilter === 'published' ? $activeTabClass : $tabClass }}">
                        Published ({{ $publishedQuestionsCount }})
                    </button>
                    <span>|</span>
                    <button wire:click="setQuickFilter('pending')" class="{{ $quickFilter === 'pending' ? $activeTabClass : $tabClass }}">
                        Pending ({{ $pendingQuestionsCount }})
                    </button>
                </div>

                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search questions..."
                           class="block w-full pl-9 pr-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <select class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option>Bulk Actions</option>
                </select>
                <button type="button" class="px-4 py-2 text-sm border border-gray-300 rounded-md bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    Apply
                </button>
                <select class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option>All dates</option>
                </select>
                <select wire:model.live="subjectId" class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">All Categories</option>
                    @foreach($subjects as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="topicId" class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">All Topics</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </select>
                <select wire:model.live="questionTypeFilter" class="px-3 py-2 border border-gray-300 rounded-md text-sm bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    <option value="">All formats</option>
                    <option value="mcq">MCQ</option>
                    <option value="cq">CQ</option>
                    <option value="short">Short</option>
                    <option value="written">Written</option>
                </select>
                <button type="button" wire:click="$refresh" class="px-4 py-2 text-sm border border-gray-300 rounded-md bg-white dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                    Filter
                </button>
                @if($canCreateQuestion)
                    <a wire:navigate href="{{ route('questions.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white font-medium text-sm rounded-md shadow-sm hover:bg-indigo-700 transition-all">
                        New Question
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full w-full text-sm align-middle whitespace-nowrap">
            <thead>
            <tr class="bg-gray-50/80 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-600 text-gray-500 dark:text-gray-300">
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">#ID</th>
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs w-1/3">Question Title</th>
                <th class="px-6 py-4 text-left font-semibold uppercase tracking-wider text-xs">Taxonomy</th>
                <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider text-xs">Type</th>
                <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider text-xs">Status</th>
                <th class="px-6 py-4 text-center font-semibold uppercase tracking-wider text-xs">Marks</th>
                <th class="px-6 py-4 text-right font-semibold uppercase tracking-wider text-xs">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
            @forelse($questions as $q)
                <tr class="hover:bg-indigo-50/50 dark:hover:bg-gray-700/50 transition-colors group">

                    <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                #{{ $q->id }}
                            </span>
                    </td>

                    <td class="px-6 py-4 whitespace-normal">
                        <div class="text-gray-900 dark:text-gray-100 font-medium line-clamp-2" title="{{ strip_tags($q->title) }}">
                            {!! Str::limit(strip_tags($q->title), 80) !!}
                        </div>
                        <div class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"></path></svg>
                            {{ $q->user->name }}
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">{{ $q->subject->name }}</span>
                            @if($q->topic)
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                        <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                        {{ $q->topic->name }}
                                    </span>
                            @endif
                        </div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        @php
                            $type = strtoupper($q->question_type ?? 'MCQ');
                            $badgeClass = match($type) {
                                'MCQ' => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800',
                                'CQ' => 'bg-purple-100 text-purple-700 border-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:border-purple-800',
                                default => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800'
                            };
                        @endphp
                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $badgeClass }}">
                                {{ $type }}
                            </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusClass = match($q->status) {
                                'active' => 'bg-emerald-100 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:border-emerald-800',
                                'pending' => 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-800',
                                default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600',
                            };
                        @endphp
                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-bold border {{ $statusClass }}">
                            {{ strtoupper($q->status ?? 'pending') }}
                        </span>
                    </td>

                    <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-gray-700 font-bold text-sm dark:bg-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 shadow-sm">
                                {{ $q->marks }}
                            </span>
                    </td>

                    @php
                        $canEditQuestion = $currentUser?->hasPermission('questions.update')
                            && (! $currentUser->isTeacher() || (int) $q->user_id === (int) $currentUser->id);
                        $canDeleteQuestion = $currentUser?->hasPermission('questions.delete')
                            && (! $currentUser->isTeacher() || (int) $q->user_id === (int) $currentUser->id);
                        $canToggleQuestionStatus = $currentUser?->hasPermission('questions.publish');
                    @endphp
                    <td class="px-6 py-4 text-right space-x-1">
                        @if($canToggleQuestionStatus)
                            <button type="button" onclick="confirmStatusToggle({{ $q->id }}, '{{ $q->status }}')"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md {{ $q->status === 'pending' ? 'text-emerald-500 hover:bg-emerald-500 border-emerald-100 dark:hover:bg-emerald-600' : 'text-amber-500 hover:bg-amber-500 border-amber-100 dark:hover:bg-amber-600' }} hover:text-white transition-colors hover:border-transparent dark:border-gray-600"
                                    title="{{ $q->status === 'pending' ? 'Approve Question' : 'Move to Pending' }}">
                                @if($q->status === 'pending')
                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                @else
                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                @endif
                            </button>
                        @endif

                        @if($canEditQuestion)
                            <a wire:navigate href="{{ route('questions.edit', $q) }}"
                               class="inline-flex items-center justify-center w-8 h-8 rounded-md text-indigo-500 hover:text-white hover:bg-indigo-500 transition-colors border border-indigo-100 hover:border-transparent dark:border-gray-600 dark:hover:bg-indigo-600" title="Edit Question">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        @endif

                        @if($canDeleteQuestion)
                            <button type="button" onclick="confirmDelete({{ $q->id }})"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-md text-red-500 hover:text-white hover:bg-red-500 transition-colors border border-red-100 hover:border-transparent dark:border-gray-600 dark:hover:bg-red-600" title="Delete Question">
                                <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" class="mb-3 text-gray-300 dark:text-gray-600" height="3em" width="3em" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <p class="text-lg font-medium">No questions found</p>
                            <p class="text-sm mt-1">Try adjusting your search or filter to find what you're looking for.</p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if($questions->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800/30">
            {{ $questions->links() }}
        </div>
    @endif
</div>

@push('scripts')
    <script>
        function showToast(message) {
            if (!window.Swal) return;
            Swal.fire({
                toast: true,
                icon: 'success',
                title: message,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        }

        function confirmDelete(id) {
            if (!window.Swal) return;
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'rounded-md px-4 py-2 font-medium',
                    cancelButton: 'rounded-md px-4 py-2 font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('deleteQuestionConfirmed', { id: id });
                }
            });
        }

        function confirmStatusToggle(id, currentStatus) {
            if (!window.Swal) return;
            const isPending = currentStatus === 'pending';
            Swal.fire({
                title: isPending ? 'Approve this question?' : 'Move this question to pending?',
                text: isPending
                    ? 'This question will become visible as an active question.'
                    : 'This question will be moved back to pending for review.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isPending ? '#10b981' : '#f59e0b',
                cancelButtonColor: '#6b7280',
                confirmButtonText: isPending ? 'Yes, approve it!' : 'Yes, move it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'rounded-md px-4 py-2 font-medium',
                    cancelButton: 'rounded-md px-4 py-2 font-medium'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('toggleQuestionStatusConfirmed', { id: id });
                }
            });
        }

        window.sessionSuccess = @json(session('success'));

        function handleSessionToast() {
            if (window.sessionSuccess) {
                showToast(window.sessionSuccess);
                window.sessionSuccess = null;
            }
        }

        document.addEventListener('DOMContentLoaded', handleSessionToast);
        document.addEventListener('livewire:navigated', handleSessionToast);

        window.addEventListener('questionDeleted', e => {
            showToast(e.detail.message || 'Question has been deleted successfully.');
        });

        window.addEventListener('questionStatusUpdated', e => {
            showToast(e.detail.message || 'Question status has been updated successfully.');
        });
    </script>
@endpush

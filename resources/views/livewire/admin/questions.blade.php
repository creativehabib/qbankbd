<div class="space-y-6">
    @php
        $currentUser = auth()->user();
        $canCreateQuestion = $currentUser?->hasPermission('questions.create');
        $canDeleteQuestion = $currentUser?->hasPermission('questions.delete');
        $canPublishQuestion = $currentUser?->hasPermission('questions.publish');
    @endphp

    <flux:card class="overflow-hidden !p-0">
        <div class="border-b border-zinc-200 bg-zinc-50/70 p-5 dark:border-zinc-700 dark:bg-zinc-800/40">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <flux:heading size="lg">Question Bank</flux:heading>
                    <flux:subheading>Review, publish, archive, and restore submitted questions.</flux:subheading>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($canCreateQuestion)
                        <flux:button href="{{ route('questions.bulk-upload') }}" wire:navigate variant="outline" icon="arrow-up-tray">Bulk upload</flux:button>
                        <flux:button href="{{ route('questions.create') }}" wire:navigate variant="primary" icon="plus">New question</flux:button>
                    @endif
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 text-sm">
                @foreach([
                    'all' => ['All', $allQuestionsCount],
                    'mine' => ['Mine', $mineQuestionsCount],
                    'published' => ['Published', $publishedQuestionsCount],
                    'pending' => ['Pending', $pendingQuestionsCount],
                    'rejected' => ['Rejected', $rejectedQuestionsCount],
                    'trash' => ['Trash', $trashedQuestionsCount],
                ] as $filter => [$label, $count])
                    <button wire:click="setQuickFilter('{{ $filter }}')" @class([
                        'rounded-full px-3 py-1.5 font-medium transition',
                        'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' => $quickFilter === $filter,
                        'text-zinc-600 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' => $quickFilter !== $filter,
                    ])>
                        {{ $label }} <span class="opacity-70">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="space-y-4 p-5">
            <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-5">
                <flux:input wire:model.live.debounce.400ms="search" icon="magnifying-glass" placeholder="Search question, subject, chapter..." class="xl:col-span-2" />

                <flux:select wire:model.live="academicClassId" placeholder="All classes">
                    <option value="">All classes</option>
                    @foreach($academicClasses as $academicClass)
                        <option value="{{ $academicClass->id }}">{{ $academicClass->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="subjectId" :disabled="$academicClassId === ''" placeholder="All subjects">
                    <option value="">All subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="questionTypeFilter" placeholder="All formats">
                    <option value="">All formats</option>
                    <option value="mcq">MCQ</option>
                    <option value="cq">CQ</option>
                    <option value="short">Short</option>
                    <option value="written">Written</option>
                </flux:select>

                <flux:select wire:model.live="chapterId" :disabled="$subjectId === ''" placeholder="All chapters">
                    <option value="">All chapters</option>
                    @foreach($chapters as $chapter)
                        <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                    @endforeach
                </flux:select>

                <flux:select wire:model.live="topicId" :disabled="$chapterId === ''" placeholder="All topics">
                    <option value="">All topics</option>
                    @foreach($topics as $topic)
                        <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                    @endforeach
                </flux:select>
            </div>

            @if($canDeleteQuestion && $selectedQuestionIds !== [])
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3 dark:border-indigo-800 dark:bg-indigo-950/30">
                    <flux:text><strong>{{ count($selectedQuestionIds) }}</strong> question(s) selected.</flux:text>
                    <div class="flex gap-2">
                        @if($quickFilter === 'trash')
                            <flux:button size="sm" variant="outline" icon="arrow-uturn-left" wire:click="confirmAction('restore')">Restore</flux:button>
                            <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmAction('force_delete')">Delete permanently</flux:button>
                        @else
                            <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmAction('trash')">Move to trash</flux:button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto border-t border-zinc-200 dark:border-zinc-700">
            <flux:table class="px-6">
                <flux:table.columns>
                    @if($canDeleteQuestion)<flux:table.column class="w-16 pl-4"><flux:checkbox wire:model.live="selectPage" aria-label="Select all questions" /></flux:table.column>@endif
                    <flux:table.column>QUESTION</flux:table.column>
                    <flux:table.column>TAXONOMY</flux:table.column>
                    <flux:table.column>TYPE</flux:table.column>
                    <flux:table.column>MARKS</flux:table.column>
                    <flux:table.column>PAYMENT</flux:table.column>
                    <flux:table.column>STATUS</flux:table.column>
                    <flux:table.column align="right">ACTIONS</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($questions as $question)
                        <flux:table.row wire:key="question-{{ $quickFilter }}-{{ $question->id }}">
                            @if($canDeleteQuestion)
                                <flux:table.cell class="w-16 pl-4"><flux:checkbox wire:model.live="selectedQuestionIds" value="{{ $question->id }}" aria-label="Select question {{ $question->id }}" /></flux:table.cell>
                            @endif
                            <flux:table.cell class="min-w-80">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ str(strip_tags($question->title))->limit(100) }}</div>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>#{{ $question->id }}</span><span>•</span><span>{{ $question->user?->name ?? 'Unknown teacher' }}</span>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="space-y-1 text-sm">
                                    <div>{{ $question->academicClass?->name ?? '—' }} <span class="text-zinc-400">/</span> {{ $question->subject?->name ?? '—' }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $question->chapter?->name ?? 'No chapter' }} <span class="text-zinc-400">/</span> {{ $question->topic?->name ?? 'No topic' }}</div>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell><flux:badge size="sm" variant="outline">{{ strtoupper($question->question_type) }}</flux:badge></flux:table.cell>
                            <flux:table.cell>{{ $question->marks }}</flux:table.cell>
                            <flux:table.cell><flux:badge size="sm" :color="$question->is_paid ? 'green' : 'zinc'">{{ $question->is_paid ? 'PAID' : 'UNPAID' }}</flux:badge></flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" :color="match($question->status) { 'active' => 'green', 'pending' => 'amber', default => 'red' }">{{ $question->status === 'inactive' ? 'REJECTED' : strtoupper($question->status) }}</flux:badge>
                            </flux:table.cell>
                            <flux:table.cell align="right">
                                <div class="flex justify-end gap-1">
                                    <flux:button size="sm" variant="ghost" icon="eye" wire:click="openQuestionModal({{ $question->id }})" aria-label="View question" />
                                    @if($quickFilter === 'trash' && $canDeleteQuestion)
                                        <flux:button size="sm" variant="ghost" icon="arrow-uturn-left" wire:click="confirmAction('restore', {{ $question->id }})" aria-label="Restore question" />
                                        <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmAction('force_delete', {{ $question->id }})" aria-label="Permanently delete question" />
                                    @elseif($quickFilter !== 'trash')
                                        @if($canPublishQuestion)
                                            @if($question->status === 'pending')
                                                <flux:button size="sm" variant="primary" icon="check" wire:click="confirmAction('approve', {{ $question->id }})">Approve</flux:button>
                                                <flux:button size="sm" variant="danger" icon="x-mark" wire:click="confirmAction('reject', {{ $question->id }})">Reject</flux:button>
                                            @elseif($question->status === 'active')
                                                <flux:button size="sm" variant="outline" icon="arrow-path" wire:click="confirmAction('unapprove', {{ $question->id }})">Unapprove</flux:button>
                                            @endif
                                        @endif
                                        @if($currentUser?->hasPermission('questions.update') && (! $currentUser->isTeacher() || $question->user_id === $currentUser->id))
                                            <flux:button size="sm" variant="ghost" icon="pencil-square" href="{{ route('questions.edit', $question) }}" wire:navigate aria-label="Edit question" />
                                        @endif
                                        @if($canDeleteQuestion && (! $currentUser->isTeacher() || $question->user_id === $currentUser->id))
                                            <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmAction('trash', {{ $question->id }})" aria-label="Move question to trash" />
                                        @endif
                                    @endif
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row><flux:table.cell :colspan="$canDeleteQuestion ? 8 : 7" class="py-14 text-center text-zinc-500">No questions found for the selected filters.</flux:table.cell></flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        @if($questions->hasPages())<div class="border-t border-zinc-200 p-4 dark:border-zinc-700">{{ $questions->links() }}</div>@endif
    </flux:card>

    <flux:modal wire:model="showQuestionModal" class="w-full max-w-4xl">
        @if($selectedQuestion)
            <div class="space-y-5">
                <div class="flex items-start justify-between gap-4"><div><flux:heading size="lg">Question review</flux:heading><flux:subheading>Submitted by {{ $selectedQuestion->user?->name ?? 'Unknown teacher' }}</flux:subheading></div><flux:badge :color="match($selectedQuestion->status) { 'active' => 'green', 'pending' => 'amber', default => 'red' }">{{ strtoupper($selectedQuestion->status) }}</flux:badge></div>
                <flux:card class="!p-4"><div class="prose max-w-none dark:prose-invert" data-math-content>{!! $selectedQuestion->title !!}</div>@if($selectedQuestion->description)<div class="mt-4 border-t pt-4 text-sm text-zinc-600 dark:text-zinc-300" data-math-content>{!! $selectedQuestion->description !!}</div>@endif</flux:card>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4"><flux:card class="!p-3"><flux:text class="text-xs">Class</flux:text><div class="font-medium">{{ $selectedQuestion->academicClass?->name ?? '—' }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Subject</flux:text><div class="font-medium">{{ $selectedQuestion->subject?->name ?? '—' }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Chapter</flux:text><div class="font-medium">{{ $selectedQuestion->chapter?->name ?? '—' }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Topic</flux:text><div class="font-medium">{{ $selectedQuestion->topic?->name ?? '—' }}</div></flux:card></div>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4"><flux:card class="!p-3"><flux:text class="text-xs">Type</flux:text><div class="font-medium uppercase">{{ $selectedQuestion->question_type }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Difficulty</flux:text><div class="font-medium capitalize">{{ $selectedQuestion->difficulty }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Marks</flux:text><div class="font-medium">{{ $selectedQuestion->marks }}</div></flux:card><flux:card class="!p-3"><flux:text class="text-xs">Payment</flux:text><div class="font-medium">{{ $selectedQuestion->is_paid ? 'Paid' : 'Unpaid' }}</div></flux:card></div>
                @if($selectedQuestion->question_type === 'mcq' && filled($selectedQuestion->extra_content))
                    <div><flux:heading size="sm">Options</flux:heading><div class="mt-3 grid gap-3 sm:grid-cols-2">@foreach($selectedQuestion->extra_content as $option)<div class="rounded-lg border p-3 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-950/30' : 'border-zinc-200 dark:border-zinc-700' }}"><div class="flex gap-2"><flux:badge size="sm" :color="!empty($option['is_correct']) ? 'green' : 'zinc'">{{ !empty($option['is_correct']) ? 'Correct' : 'Option' }}</flux:badge><div class="text-sm" data-math-content>{!! $option['option_text'] ?? '' !!}</div></div></div>@endforeach</div></div>
                @elseif($selectedQuestion->question_type === 'cq' && filled($selectedQuestion->extra_content))
                    <div><flux:heading size="sm">Creative question parts</flux:heading><div class="mt-3 space-y-3">@foreach($selectedQuestion->extra_content as $part)<flux:card class="!p-3"><div class="flex items-start justify-between gap-3"><div class="font-medium" data-math-content>{{ $part['label'] ?? 'Part' }}. {!! $part['text'] ?? '' !!}</div><flux:badge size="sm" variant="outline">{{ $part['marks'] ?? 0 }} marks</flux:badge></div>@if(filled($part['answer'] ?? null))<div class="mt-2 border-t pt-2 text-sm text-zinc-600 dark:text-zinc-300" data-math-content><strong>Answer:</strong> {!! $part['answer'] !!}</div>@endif</flux:card>@endforeach</div></div>
                @endif
                <div class="flex justify-end gap-2"><flux:modal.close><flux:button variant="ghost">Close</flux:button></flux:modal.close>@if($canPublishQuestion && $selectedQuestion->status === 'pending')<flux:button variant="danger" icon="x-mark" wire:click="confirmAction('reject', {{ $selectedQuestion->id }})">Reject</flux:button><flux:button variant="primary" icon="check" wire:click="confirmAction('approve', {{ $selectedQuestion->id }})">Approve</flux:button>@endif@if($canPublishQuestion && $selectedQuestion->status === 'active')<flux:button variant="outline" icon="arrow-path" wire:click="confirmAction('unapprove', {{ $selectedQuestion->id }})">Unapprove</flux:button>@endif</div>
            </div>
        @endif
    </flux:modal>

    <flux:modal wire:model="showConfirmationModal" class="w-full max-w-lg">
        <div class="space-y-5"><div><flux:heading size="lg">{{ $confirmationTitle }}</flux:heading><flux:text class="mt-2">{{ $confirmationDescription }}</flux:text></div><div class="flex justify-end gap-2"><flux:modal.close><flux:button variant="ghost">Cancel</flux:button></flux:modal.close><flux:button :variant="in_array($confirmationAction, ['trash', 'force_delete', 'reject'], true) ? 'danger' : 'primary'" wire:click="executeConfirmation">{{ $confirmationButton }}</flux:button></div></div>
    </flux:modal>
</div>

<x-split-layout>
    <x-slot:form>
        <form wire:submit="save" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Topic' : 'Create New Topic' }}</flux:heading>
                <flux:text class="mt-1">Add a topic and assign it to a subject and chapter.</flux:text>
            </div>

            <flux:field>
                <flux:label>Select Subject</flux:label>
                <flux:select wire:model.live="modalSubjectId" placeholder="Choose a subject...">
                    @foreach($subjects as $s)
                        <flux:select.option value="{{ $s->id }}">{{ $s->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="modalSubjectId" />
            </flux:field>

            <div wire:key="chapter-group-{{ $modalSubjectId ?? 'empty' }}">
                <flux:field>
                    <flux:label>Select Chapter (Optional)</flux:label>
                    <flux:select wire:model="modalChapterId" placeholder="Choose a chapter..." :disabled="!$modalSubjectId">
                        @foreach($modalChapters as $mc)
                            <flux:select.option value="{{ $mc->id }}">{{ $mc->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="modalChapterId" />
                </flux:field>
            </div>

            <flux:field>
                <flux:label>Topic Name</flux:label>
                <flux:input wire:model="name" placeholder="e.g. Newton's First Law" />
                <flux:error name="name" />
            </flux:field>

            <div class="flex justify-end gap-2 pt-2">
                @if($editId)
                    <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                @endif
                <flux:button type="submit" variant="primary">
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </flux:button>
            </div>
        </form>
    </x-slot:form>

    <x-slot:table>
        <div class="border-b border-gray-100 px-5 py-4 dark:border-gray-700">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <flux:heading size="lg">Topics</flux:heading>
                    <flux:text>Manage topics under subjects and chapters.</flux:text>
                </div>
            </div>

            <div class="mt-4 flex flex-col sm:flex-row gap-3">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    icon="magnifying-glass"
                    placeholder="Search topics..."
                    class="flex-1 max-w-md"
                />

                <flux:select wire:model.live="subjectId" class="w-full sm:w-48">
                    <flux:select.option value="">All Subjects</flux:select.option>
                    @foreach($subjects as $sub)
                        <flux:select.option value="{{ $sub->id }}">{{ $sub->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 dark:bg-gray-700/40 dark:text-gray-300">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold">#ID</th>
                        <th class="px-5 py-3 text-left font-semibold">Topic Name</th>
                        <th class="px-5 py-3 text-left font-semibold">Subject</th>
                        <th class="px-5 py-3 text-left font-semibold">Chapter</th>
                        <th class="px-5 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($topics as $topic)
                        <tr wire:key="topic-{{ $topic->id }}" class="transition hover:bg-indigo-50/40 dark:hover:bg-gray-700/30">
                            <td class="px-5 py-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                    #{{ $topic->id }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-900 dark:text-gray-100">
                                {{ $topic->name }}
                            </td>
                            <td class="px-5 py-3">
                                <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-md border border-indigo-100 dark:border-indigo-800">
                                    {{ $topic->subject->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-5 py-3">
                                @if($topic->chapter)
                                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 rounded-md border border-emerald-100 dark:border-emerald-800">
                                        {{ $topic->chapter->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500 italic">N/A</span>
                                @endif
                            </td>
                            <td class="px-5 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button wire:click="edit({{ $topic->id }})" variant="ghost" size="sm" icon="pencil-square" aria-label="Edit" />
                                    <flux:button x-data x-on:click="window.confirmDeleteAction(() => $wire.delete({{ $topic->id }}))" variant="danger" size="sm" icon="trash" aria-label="Delete" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                                    <p class="text-lg font-medium">No topics found</p>
                                    <p class="text-sm mt-1">Try adjusting your search or filter to find what you're looking for.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($topics->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/30 dark:bg-gray-800/30">
                {{ $topics->links() }}
            </div>
        @endif
    </x-slot:table>
</x-split-layout>

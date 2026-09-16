<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Institutions</flux:heading>
            <flux:subheading>Manage institutions for past exams.</flux:subheading>
        </div>
        <flux:button wire:click="create" variant="primary" icon="plus">
            Add Institution
        </flux:button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Form Section -->
        @if($showModal)
        <div class="xl:col-span-1">
            <flux:card>
                <flux:heading size="lg" class="mb-4">{{ $editingId ? 'Edit Institution' : 'Create Institution' }}</flux:heading>
                
                <form wire:submit.prevent="save" class="space-y-5">
                    
                    <flux:field>
                        <flux:label>Institution Name</flux:label>
                        <flux:input wire:model="name" placeholder="e.g., BPSC" />
                        <flux:error name="name" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Slug (URL)</flux:label>
                        <flux:input wire:model="slug" placeholder="e.g. bpsc" />
                        <flux:error name="slug" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Description (Optional)</flux:label>
                        <flux:textarea wire:model="description" placeholder="About the institution..." />
                        <flux:error name="description" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Official Website (Optional)</flux:label>
                        <flux:input wire:model="official_website" placeholder="https://example.com" />
                        <flux:error name="official_website" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Logo</flux:label>
                        <input type="file" wire:model="logo" class="w-full text-sm mt-1 border border-zinc-300 rounded p-1 dark:border-zinc-700" />
                        <flux:error name="logo" />
                    </flux:field>

                    <div class="flex gap-2 pt-2">
                        <flux:button wire:click="$set('showModal', false)" variant="subtle" class="w-full">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" class="w-full">Save</flux:button>
                    </div>
                </form>
            </flux:card>
        </div>
        @endif

        <!-- List Section -->
        <div class="{{ $showModal ? 'xl:col-span-2' : 'xl:col-span-3' }}">
            <flux:card class="!p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Name</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Slug</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Website</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($institutions as $inst)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $inst->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        {{ $inst->slug ?: '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        @if($inst->official_website)
                                            <a href="{{ $inst->official_website }}" target="_blank" class="text-blue-500 hover:underline">Link</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <flux:button wire:click="edit({{ $inst->id }})" size="sm" variant="subtle" icon="pencil-square" />
                                            <flux:button wire:click="delete({{ $inst->id }})" size="sm" variant="danger" icon="trash" wire:confirm="Are you sure?" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-zinc-500">
                                        No institutions found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($institutions->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $institutions->links() }}
                    </div>
                @endif
            </flux:card>
        </div>
    </div>
</div>

<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">Past Exams (বিগত পরীক্ষা)</flux:heading>
            <flux:subheading>Manage past exam papers and assign questions to them.</flux:subheading>
        </div>
        <flux:button wire:click="create" variant="primary" icon="plus">
            Add Past Exam
        </flux:button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        
        <!-- Form Section -->
        @if($showModal)
        <div class="xl:col-span-1">
            <flux:card>
                <flux:heading size="lg" class="mb-4">{{ $editingId ? 'Edit Exam' : 'Create Exam' }}</flux:heading>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    <flux:field>
                        <flux:label>Title (e.g. 45th BCS Preliminary)</flux:label>
                        <flux:input wire:model="title" />
                        <flux:error name="title" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Slug (URL)</flux:label>
                        <flux:input wire:model="slug" placeholder="e.g. bcs-preli-45" />
                        <flux:error name="slug" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Description / Details</flux:label>
                        <flux:textarea wire:model="description" rows="3" placeholder="Enter exam details..." />
                        <flux:error name="description" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Exam Type</flux:label>
                        <flux:select wire:model="type">
                            <option value="mcq">Multiple Choice (MCQ)</option>
                            <option value="cq">Creative Question (CQ)</option>
                            <option value="short">Short Question</option>
                            <option value="written">Written Question (লিখিত)</option>
                            <option value="both">Mix / Both</option>
                        </flux:select>
                        <flux:error name="type" />
                    </flux:field>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Institution</flux:label>
                            <flux:select wire:model="institution_id">
                                <option value="">-- None --</option>
                                @foreach($institutions as $inst)
                                    <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                @endforeach
                            </flux:select>
                        </flux:field>

                        <flux:field>
                            <flux:label>Category</flux:label>
                            <flux:select wire:model="exam_category_id">
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Exam Date</flux:label>
                            <flux:input type="date" wire:model="exam_date" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Grade (e.g. 9th-10th)</flux:label>
                            <flux:input wire:model="grade" />
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Total Marks</flux:label>
                            <flux:input type="number" wire:model="total_marks" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Total Questions</flux:label>
                            <flux:input type="number" wire:model="total_questions" />
                        </flux:field>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
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
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Title</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Institution</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Type</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Questions</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($exams as $exam)
                                <tr class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-4 font-medium text-zinc-900 dark:text-zinc-100">{{ $exam->title }}</td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">{{ $exam->institution?->name ?? '-' }}</td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        <span class="bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded text-xs uppercase font-bold">{{ $exam->type }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">{{ $exam->questions()->count() }} / {{ $exam->total_questions ?? '-' }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <flux:button href="{{ route('admin.past-exams.manage', $exam->id) }}" size="sm" variant="outline" icon="document-text">Manage</flux:button>
                                            <flux:button wire:click="edit({{ $exam->id }})" size="sm" variant="subtle" icon="pencil-square" />
                                            <flux:button wire:click="delete({{ $exam->id }})" size="sm" variant="danger" icon="trash" wire:confirm="Are you sure?" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-zinc-500">No exams found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($exams->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $exams->links() }}
                    </div>
                @endif
            </flux:card>
        </div>
    </div>
</div>

<x-layouts::app title="Super Admin Dashboard">
    <div class="space-y-6">

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="space-y-1 mb-2">
            <flux:heading size="xl">Super Admin Overview</flux:heading>
            <flux:subheading size="lg">Manage platform content, users, and overall system health.</flux:subheading>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <flux:card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <flux:icon.document-text class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Questions</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_questions'] }}</p>
            </flux:card>
            <flux:card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <flux:icon.users class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Users</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_users'] }}</p>
            </flux:card>
            <flux:card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <flux:icon.academic-cap class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Exams</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_exam_categories'] }}</p>
            </flux:card>
            <flux:card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <flux:icon.currency-dollar class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Revenue</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">৳ {{ number_format($overviewStats['monthly_revenue']) }}</p>
            </flux:card>
            <flux:card class="relative overflow-hidden group border-amber-200 dark:border-amber-900/50">
                <div class="absolute -right-2 -top-2 size-12 text-amber-100 dark:text-amber-900/30 opacity-20 transition-transform group-hover:scale-110">
                    <flux:icon.clock class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-amber-600 dark:text-amber-500">Pending Approval</p>
                <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-500">{{ $overviewStats['pending_approval'] }}</p>
            </flux:card>
        </div>

        <flux:card class="!p-0 overflow-hidden">
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-700">
                <flux:heading size="lg">Creator Summary</flux:heading>
                <flux:text class="!text-sm">Summary of content created by teachers.</flux:text>
            </div>
            
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>User</flux:table.column>
                    <flux:table.column>Total Sets</flux:table.column>
                    <flux:table.column>Total Questions</flux:table.column>
                    <flux:table.column>Types</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @forelse ($creatorSummary as $item)
                        <flux:table.row>
                            <flux:table.cell class="font-medium">{{ $item['user_name'] }}</flux:table.cell>
                            <flux:table.cell>{{ $item['question_set_count'] }}</flux:table.cell>
                            <flux:table.cell>{{ $item['question_total'] }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex flex-wrap gap-1">
                                @foreach ($item['types'] as $type => $count)
                                    <flux:badge size="sm" color="zinc">{{ strtoupper($type) }}: {{ $count }}</flux:badge>
                                @endforeach
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center text-zinc-500">No data found.</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <flux:card>
            <flux:heading size="lg" class="mb-4">Question Sets Management</flux:heading>
            
            <div class="space-y-4">
                @forelse ($questionSets as $questionSet)
                    <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="mb-3 text-sm text-zinc-500 dark:text-zinc-400">
                            Created by: <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $questionSet->user?->name ?? 'Unknown' }}</span>
                            · Date: {{ $questionSet->created_at?->format('d M Y, h:i A') }}
                        </div>

                        <form method="POST" action="{{ route('dashboard.question-sets.update', $questionSet) }}" class="flex flex-col sm:flex-row gap-3 items-end">
                            @csrf
                            @method('PATCH')
                            <div class="w-full sm:w-1/3">
                                <flux:input type="text" name="name" value="{{ $questionSet->name }}" label="Name" required />
                            </div>
                            <div class="w-full sm:w-1/4">
                                <flux:select name="type" label="Type" required>
                                    @foreach (['mcq' => 'MCQ', 'cq' => 'CQ', 'short' => 'SHORT', 'written' => 'WRITTEN', 'combine' => 'COMBINE'] as $key => $label)
                                        <option value="{{ $key }}" @selected(($questionSet->generation_criteria['type'] ?? 'mcq') === $key)>{{ $label }}</option>
                                    @endforeach
                                </flux:select>
                            </div>
                            <div class="w-full sm:w-1/4">
                                <flux:input type="number" min="1" max="500" name="quantity" value="{{ (int) ($questionSet->generation_criteria['quantity'] ?? 1) }}" label="Quantity" required />
                            </div>
                            <div class="w-full sm:w-auto mt-2 sm:mt-0 flex gap-2">
                                <flux:button type="submit" variant="primary" class="w-full sm:w-auto">Update</flux:button>
                                <flux:button type="button" variant="danger" icon="trash" class="w-full sm:w-auto" onclick="if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $questionSet->id }}').submit();" />
                            </div>
                        </form>
                        
                        <form id="delete-form-{{ $questionSet->id }}" method="POST" action="{{ route('dashboard.question-sets.destroy', $questionSet) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @empty
                    <div class="text-center text-sm text-zinc-500 py-4">No Question Sets found.</div>
                @endforelse
            </div>
        </flux:card>
    </div>
</x-layouts::app>

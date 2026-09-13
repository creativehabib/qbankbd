<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">Activity Logs</flux:heading>
                <flux:subheading>Monitor system-wide user activity and actions.</flux:subheading>
            </div>
        </div>
    </div>

    <flux:card>
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-4">
            <flux:heading size="lg">Recent Activity</flux:heading>
            
            <div class="flex items-center gap-3">
                <div class="w-full sm:w-64">
                    <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="Search logs..." />
                </div>
                
                @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator && $logs->total() > 0)
                    <flux:button wire:click="clearLogs" wire:confirm="আপনি কি নিশ্চিত যে সম্পূর্ণ লগ ডিলিট করতে চান?" size="sm" variant="danger" icon="trash">
                        Clear All
                    </flux:button>
                @endif
            </div>
        </div>
        
        @if(!$logs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="p-4 bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 rounded-md">
                Activity Logs table does not exist. Please run `php artisan migrate` on your server to create it.
            </div>
        @elseif($logs->isEmpty())
            <div class="py-8 text-center text-zinc-500">
                No activity logs found.
            </div>
        @else
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-left">
                        <tr>
                            <th class="py-3 px-4 font-medium">User</th>
                            <th class="py-3 px-4 font-medium">Action</th>
                            <th class="py-3 px-4 font-medium hidden md:table-cell">Description</th>
                            <th class="py-3 px-4 font-medium hidden lg:table-cell">IP Address</th>
                            <th class="py-3 px-4 font-medium">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($logs as $log)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        @if($log->user)
                                            <flux:avatar size="sm" :name="$log->user->name" :initials="$log->user->initials()" :src="$log->user->picture ? asset('storage/'.$log->user->picture) : ''" />
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $log->user->name }}</span>
                                        @else
                                            <span class="text-zinc-500 italic">System / Unknown</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-4 font-medium text-zinc-700 dark:text-zinc-300">
                                    <flux:badge size="sm" color="zinc">{{ str_replace('_', ' ', Str::title($log->action)) }}</flux:badge>
                                </td>
                                <td class="py-3 px-4 text-zinc-600 dark:text-zinc-400 hidden md:table-cell">
                                    {{ $log->description ?: '-' }}
                                </td>
                                <td class="py-3 px-4 text-zinc-500 hidden lg:table-cell text-xs font-mono">
                                    {{ $log->ip_address ?: '-' }}
                                </td>
                                <td class="py-3 px-4 text-zinc-500 text-xs">
                                    {{ $log->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        @endif
    </flux:card>
</div>
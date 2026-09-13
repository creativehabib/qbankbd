<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">System Information</flux:heading>
                <flux:subheading>View technical specifications and runtime configuration of the server.</flux:subheading>
            </div>
        </div>
    </div>

    <div class="max-w-4xl">
        <flux:card>
            <flux:heading size="lg" class="mb-4">Environment Details</flux:heading>
            
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700 text-sm">
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($systemInfo as $key => $value)
                            <tr class="even:bg-zinc-50 dark:even:bg-zinc-800/50">
                                <td class="py-3 px-4 font-medium text-zinc-900 dark:text-zinc-100 whitespace-nowrap w-1/3">
                                    {{ $key }}
                                </td>
                                <td class="py-3 px-4 text-zinc-600 dark:text-zinc-400">
                                    {{ $value ?: 'Not Available' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end">
                <flux:button variant="outline" icon="arrow-path" wire:click="$refresh">Refresh Data</flux:button>
            </div>
        </flux:card>
    </div>
</div>
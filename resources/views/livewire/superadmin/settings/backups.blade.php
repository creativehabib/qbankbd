<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl">System Backups</flux:heading>
            <flux:subheading>ডাটাবেজ এবং সম্পূর্ণ প্রজেক্টের ব্যাকআপ তৈরি, ডাউনলোড বা মুছে ফেলুন।</flux:subheading>
        </div>

        <div class="flex items-center gap-3">
            <flux:button wire:click="cleanBackups" wire:loading.attr="disabled" icon="trash" size="sm" variant="danger">
                <span wire:loading.remove wire:target="cleanBackups">Clean Old</span>
                <span wire:loading wire:target="cleanBackups">Cleaning...</span>
            </flux:button>
            <flux:button wire:click="runBackup(true)" wire:loading.attr="disabled" icon="circle-stack" size="sm" variant="outline">
                <span wire:loading.remove wire:target="runBackup(true)">Database Only</span>
                <span wire:loading wire:target="runBackup(true)">Processing...</span>
            </flux:button>
            <flux:button wire:click="runBackup(false)" wire:loading.attr="disabled" icon="folder-arrow-down" size="sm" variant="primary">
                <span wire:loading.remove wire:target="runBackup(false)">Full Backup</span>
                <span wire:loading wire:target="runBackup(false)">Processing...</span>
            </flux:button>
        </div>
    </div>

    <flux:card class="!p-0 overflow-hidden">
        <flux:table class="px-6">
            <flux:table.columns>
                <flux:table.column>BACKUP NAME</flux:table.column>
                <flux:table.column>SIZE</flux:table.column>
                <flux:table.column>CREATED AT</flux:table.column>
                <flux:table.column align="right">ACTIONS</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($this->backups as $backup)
                    <flux:table.row>
                        <flux:table.cell>
                            <div class="flex items-center gap-2">
                                <flux:icon.archive-box class="w-5 h-5 text-zinc-400" />
                                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $backup['file_name'] }}</span>
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-600 dark:text-zinc-400">
                            {{ $backup['file_size'] }}
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-600 dark:text-zinc-400">
                            {{ $backup['date']->format('d M Y, h:i A') }}
                            <span class="text-xs text-zinc-400 ml-1">({{ $backup['date']->diffForHumans() }})</span>
                        </flux:table.cell>
                        <flux:table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <flux:button wire:click="downloadBackup('{{ $backup['path'] }}')" icon="arrow-down-tray" size="sm" variant="outline">
                                    Download
                                </flux:button>
                                <flux:button wire:click="deleteBackup('{{ $backup['path'] }}')" wire:confirm="আপনি কি নিশ্চিত যে এই ব্যাকআপটি ডিলিট করতে চান?" icon="trash" size="sm" variant="danger" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="4" class="py-12 text-center text-zinc-500">
                            <flux:icon.exclamation-triangle class="w-12 h-12 mx-auto text-zinc-300 mb-3" />
                            <p class="text-base font-medium text-zinc-900 dark:text-zinc-100">কোনো ব্যাকআপ পাওয়া যায়নি!</p>
                            <p class="text-sm mt-1">উপরে ডানদিকের বাটন থেকে নতুন ব্যাকআপ তৈরি করুন।</p>
                        </flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>

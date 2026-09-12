@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between px-5 py-4 border-t border-zinc-100 dark:border-zinc-800 text-sm text-zinc-500 dark:text-zinc-400">
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2">
                <select wire:model.live="perPage" class="py-1 px-2 pr-8 border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 rounded-md text-sm focus:ring-accent focus:border-accent dark:text-white">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>/ page</span>
            </div>
            
            <span class="hidden sm:inline-block text-zinc-300 dark:text-zinc-600">&middot;</span>
            
            <p>
                Showing
                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $paginator->total() }}</span>
            </p>
        </div>

        <div class="mt-4 sm:mt-0">
            <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span class="relative inline-flex items-center rounded-l-md px-3 py-2 text-sm text-zinc-400 dark:text-zinc-500 cursor-not-allowed bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                        Previous
                    </span>
                @else
                    <button wire:click="previousPage" wire:loading.attr="disabled" class="relative inline-flex items-center rounded-l-md px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                        Previous
                    </button>
                @endif

                {{-- Pagination Elements (Just show current page for simplicity to match image exactly, or a few elements) --}}
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-accent bg-accent/10 border-y border-zinc-200 dark:border-zinc-700">
                    {{ $paginator->currentPage() }}
                </span>

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button wire:click="nextPage" wire:loading.attr="disabled" class="relative inline-flex items-center rounded-r-md px-3 py-2 text-sm text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-700 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                        Next
                    </button>
                @else
                    <span class="relative inline-flex items-center rounded-r-md px-3 py-2 text-sm text-zinc-400 dark:text-zinc-500 cursor-not-allowed bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
                        Next
                    </span>
                @endif
            </nav>
        </div>
    </div>
@endif

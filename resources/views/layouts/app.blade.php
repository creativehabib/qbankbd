<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="flex flex-col min-h-[calc(100vh-theme(spacing.16))]">
        <div class="flex-1">
            {{ $slot }}
        </div>
        
        @php
            $footerText = \App\Support\SettingsStore::group('branding')['footer_text'] ?? '';
        @endphp
        
        @if(filled($footerText))
            <footer class="mt-auto py-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                {{ $footerText }}
            </footer>
        @endif
    </flux:main>
</x-layouts::app.sidebar>

<x-layouts::app.sidebar :title="$title ?? null">
    @isset($header)
        <div class="sticky top-0 z-30 border-b border-zinc-200 bg-white/95 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/95">
            {{ $header }}
        </div>
    @endisset

    <flux:main class="pt-5">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>

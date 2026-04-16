@php
    $pageTitle = $title ?? 'Dashboard';
@endphp

<x-layouts::app.sidebar :title="$title ?? null">
    <div class="sticky top-0 z-30 hidden border-b border-zinc-200 bg-white/95 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/95 lg:block">
        @isset($header)
            {{ $header }}
        @else
            <div class="px-6 py-2">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $pageTitle }}</h1>

                    <div class="flex items-center gap-2">
                        <flux:button variant="ghost" icon="moon" size="sm">{{ __('Theme') }}</flux:button>
                        <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" />
                    </div>
                </div>
            </div>
        @endisset
    </div>

    <flux:main class="pt-5">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>

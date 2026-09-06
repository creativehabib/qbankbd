@props([
    'sidebar' => false,
])

@if($sidebar)
    <a
        {{ $attributes->class('flex h-8 min-w-0 items-center justify-center in-data-flux-sidebar-collapsed-desktop:w-full') }}
        aria-label="{{ __('Question Bank') }}"
    >
        <span
            data-test="sidebar-full-logo"
            class="block h-8 w-auto in-data-flux-sidebar-collapsed-desktop:hidden [&>svg]:h-full [&>svg]:w-auto"
        >
            <x-app-logo-icon />
        </span>

        <span
            data-test="sidebar-collapsed-logo"
            title="{{ __('Question Bank') }}"
            class="hidden size-8 in-data-flux-sidebar-collapsed-desktop:block [&>svg]:size-full"
        >
            <x-app-icon />
        </span>
    </a>
@else
    <flux:brand name="Question Bank" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </x-slot>
    </flux:brand>
@endif

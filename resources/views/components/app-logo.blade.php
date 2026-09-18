@props([
    'sidebar' => false,
])

@php
    $branding = \App\Support\SettingsStore::group('branding');
    $appName = $branding['app_name'] ?? config('app.name', 'Question Bank');
    $logoLight = !empty($branding['logo_light']) ? (\Illuminate\Support\Str::startsWith($branding['logo_light'], ['http://', 'https://']) ? $branding['logo_light'] : asset('storage/'.$branding['logo_light'])) : asset('images/logo_dark.png');
    $logoDark = !empty($branding['logo_dark']) ? (\Illuminate\Support\Str::startsWith($branding['logo_dark'], ['http://', 'https://']) ? $branding['logo_dark'] : asset('storage/'.$branding['logo_dark'])) : asset('images/logo_light.png');
    $iconLight = !empty($branding['icon_light']) ? (\Illuminate\Support\Str::startsWith($branding['icon_light'], ['http://', 'https://']) ? $branding['icon_light'] : asset('storage/'.$branding['icon_light'])) : null;
    $iconDark = !empty($branding['icon_dark']) ? (\Illuminate\Support\Str::startsWith($branding['icon_dark'], ['http://', 'https://']) ? $branding['icon_dark'] : asset('storage/'.$branding['icon_dark'])) : null;
@endphp

@if($sidebar)
    <a
        {{ $attributes->class('flex h-10 min-w-0 items-center justify-center in-data-flux-sidebar-collapsed-desktop:w-full') }}
        aria-label="{{ $appName }}"
    >
        <span
            data-test="sidebar-full-logo"
            class="block h-10 w-auto in-data-flux-sidebar-collapsed-desktop:hidden"
        >
            @if($logoLight || $logoDark)
                @if($logoLight)
                    <img src="{{ $logoLight }}" class="h-10 w-auto object-contain dark:hidden" alt="{{ $appName }}" />
                @endif
                @if($logoDark)
                    <img src="{{ $logoDark }}" class="h-10 w-auto object-contain hidden dark:block" alt="{{ $appName }}" />
                @endif
            @else
                <div class="h-10 flex items-center justify-center">
                    <x-app-logo-icon class="h-8 w-auto shrink-0" />
                </div>
            @endif
        </span>

        <span
            data-test="sidebar-collapsed-logo"
            title="{{ $appName }}"
            class="hidden size-10 in-data-flux-sidebar-collapsed-desktop:flex items-center justify-center"
        >
            @if($iconLight || $iconDark)
                @if($iconLight)
                    <img src="{{ $iconLight }}" class="max-h-full max-w-full object-contain dark:hidden" alt="Icon" />
                @endif
                @if($iconDark)
                    <img src="{{ $iconDark }}" class="max-h-full max-w-full object-contain hidden dark:block" alt="Icon" />
                @endif
            @else
                <div class="size-10 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-lg flex items-center justify-center font-bold text-xl">{{ substr($appName, 0, 1) }}</div>
            @endif
        </span>
    </a>
@else
    <flux:brand name="{{ $appName }}" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            @if($iconLight || $iconDark)
                @if($iconLight)
                    <img src="{{ $iconLight }}" class="size-6 object-contain dark:hidden" alt="Icon" />
                @endif
                @if($iconDark)
                    <img src="{{ $iconDark }}" class="size-6 object-contain hidden dark:block" alt="Icon" />
                @endif
            @else
                <div class="size-8 bg-zinc-900 dark:bg-white text-white dark:text-black rounded-lg flex items-center justify-center font-bold text-lg">{{ substr($appName, 0, 1) }}</div>
            @endif
        </x-slot>
    </flux:brand>
@endif

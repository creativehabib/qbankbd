@php
    $questionGroupItems = [
        ['label' => __('Questions'), 'route' => 'questions.index', 'match' => 'questions.*', 'visible' => true],
        ['label' => __('Exam Categories'), 'route' => 'exam-categories.index', 'match' => 'exam-categories.*', 'visible' => auth()->user()->hasAnyPermission(['exam_categories.manage'])],
        ['label' => __('Academic Class'), 'route' => 'academic-classes.index', 'match' => 'academic-classes.*', 'visible' => auth()->user()->hasAnyPermission(['academic_classes.manage'])],
        ['label' => __('Subjects'), 'route' => 'subjects.index', 'match' => 'subjects.*', 'visible' => auth()->user()->hasAnyPermission(['subjects.manage'])],
        ['label' => __('Chapter'), 'route' => 'chapters.index', 'match' => 'chapters.*', 'visible' => auth()->user()->hasAnyPermission(['chapters.manage'])],
        ['label' => __('Topics'), 'route' => 'topics.index', 'match' => 'topics.*', 'visible' => auth()->user()->hasAnyPermission(['topics.manage'])],
        ['label' => __('Tags'), 'route' => 'tags.index', 'match' => 'tags.*', 'visible' => auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete'])],
    ];

    $singleItems = [
        ['label' => __('Dashboard'), 'route' => 'dashboard', 'match' => 'dashboard', 'icon' => 'home', 'visible' => true],
        ['label' => __('Question Create'), 'route' => 'questions.set.create', 'match' => 'questions.set.create.*', 'icon' => 'plus-circle', 'visible' => true],
        ['label' => __('OMR Generator'), 'route' => 'omr.generator', 'match' => 'omr.generator', 'icon' => 'document-duplicate', 'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin'])],
        ['label' => __('Practice'), 'route' => 'students.practice.index', 'match' => 'students.practice.*', 'icon' => 'book-open', 'visible' => auth()->user()->isStudent()],
    ];

    $adminItems = [
        ['label' => __('User Management'), 'route' => 'users.index', 'match' => 'users.*', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
        ['label' => __('Theme Options'), 'route' => 'admin.theme-options', 'match' => 'admin.theme-options', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
        ['label' => __('Permissions'), 'route' => 'permissions.index', 'match' => 'permissions.*', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
        ['label' => __('Roles & Permissions'), 'route' => 'roles-permissions.index', 'match' => 'roles-permissions.*', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
    ];

    $questionGroupExpanded = request()->routeIs(['questions.*', 'exam-categories.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*']);
    $questionGroupActive = $questionGroupExpanded;
    $adminGroupExpanded = request()->routeIs(['users.*', 'admin.theme-options', 'permissions.*', 'roles-permissions.*']);
    $adminGroupActive = $adminGroupExpanded;
    $pageTitle = $title ?? $pageTitle ?? 'Dashboard';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        mobileSidebarOpen: false,
        sidebarCollapsed: JSON.parse(localStorage.getItem('sidebar-collapsed') ?? 'false'),
        activeFlyout: null,
        flyoutCloseTimer: null,
        profileMenuOpen: false,
        collapsedProfileMenuOpen: false,
        pageLoading: false,
        theme: localStorage.getItem('theme') ?? (document.documentElement.classList.contains('dark') ? 'dark' : 'light'),
        setTheme(mode) {
            this.theme = mode;
            localStorage.setItem('theme', mode);
            document.documentElement.classList.toggle('dark', mode === 'dark');
        },
        toggleTheme() {
            this.setTheme(this.theme === 'dark' ? 'light' : 'dark');
        }
    }"
    x-init="$watch('sidebarCollapsed', (value) => { localStorage.setItem('sidebar-collapsed', JSON.stringify(value)); if (! value) { activeFlyout = null; collapsedProfileMenuOpen = false; } }); setTheme(theme); window.addEventListener('beforeunload', () => pageLoading = true); document.addEventListener('livewire:navigating', () => pageLoading = true); document.addEventListener('livewire:navigated', () => pageLoading = false);"
    @click.capture="if ($event.target.closest('a[wire\\:navigate]')) { pageLoading = true; }"
    class="min-h-screen bg-gray-50 print:bg-white dark:bg-[var(--app-dark-bg)]"
>
<div class="flex min-h-screen">
    <aside class="fixed inset-y-0 left-0 z-40 hidden flex-col border-e border-zinc-200 bg-zinc-50 transition-all duration-200 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:flex" :class="sidebarCollapsed ? 'w-16' : 'w-72'" data-test="desktop-sidebar">
        <div class="flex items-center justify-between border-b border-zinc-200 px-3 py-3 dark:border-[var(--app-dark-border)]">
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate x-show="! sidebarCollapsed" />
            <button type="button" class="rounded-md border border-zinc-300 p-2 text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800" @click="sidebarCollapsed = ! sidebarCollapsed" data-test="sidebar-collapse-button" title="Toggle sidebar">◨</button>
        </div>

        <nav class="relative flex-1 space-y-2 p-2" :class="sidebarCollapsed ? 'overflow-visible' : 'overflow-y-auto'" data-test="sidebar-nav">
            <template x-if="! sidebarCollapsed">
                <div class="space-y-2">
                    @foreach($singleItems as $item)
                        @if($item['visible'])
                            <a href="{{ route($item['route']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>
                                <span class="inline-flex h-4 w-4 items-center justify-center">
                                    @switch($item['icon'])
                                        @case('home')
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.592 0L21.75 12M4.5 9.75V19.5A1.5 1.5 0 0 0 6 21h3.75v-5.25a1.5 1.5 0 0 1 1.5-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5V21H18a1.5 1.5 0 0 0 1.5-1.5V9.75" /></svg>
                                            @break
                                        @case('plus-circle')
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" /></svg>
                                            @break
                                        @case('document-duplicate')
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125H5.625A1.125 1.125 0 0 1 4.5 20.625V8.625c0-.621.504-1.125 1.125-1.125H9.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 3.75H10.875A1.125 1.125 0 0 0 9.75 4.875v9.75c0 .621.504 1.125 1.125 1.125H18.75c.621 0 1.125-.504 1.125-1.125V8.625L15 3.75Z" /></svg>
                                            @break
                                        @case('book-open')
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h6.75A2.25 2.25 0 0 1 13.5 6.75v12.75a2.25 2.25 0 0 0-2.25-2.25H4.5a2.25 2.25 0 0 0-2.25 2.25V6.75Zm19.5 0A2.25 2.25 0 0 0 19.5 4.5h-6.75A2.25 2.25 0 0 0 10.5 6.75v12.75a2.25 2.25 0 0 1 2.25-2.25h6.75a2.25 2.25 0 0 1 2.25 2.25V6.75Z" /></svg>
                                            @break
                                    @endswitch
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @endif
                    @endforeach

                    <div x-data="{ open: {{ $questionGroupExpanded ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="open ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                        <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold" @click="open = ! open">
                            <span>{{ __('প্রশ্ন ভান্ডার') }}</span>
                            <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="open" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 dark:border-zinc-700">
                            @foreach($questionGroupItems as $item)
                                @if($item['visible'])
                                    <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ $item['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    @if(auth()->user()->hasPermission('users.manage_roles'))
                        <div x-data="{ open: {{ $adminGroupExpanded ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="open ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                            <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold" @click="open = ! open">
                                <span>{{ __('Administration') }}</span>
                                <svg class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                            </button>
                            <div x-show="open" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 dark:border-zinc-700">
                                @foreach($adminItems as $item)
                                    @if($item['visible'])
                                        <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ $item['label'] }}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </template>

            <template x-if="sidebarCollapsed">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex h-10 items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="Dashboard" wire:navigate><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955a1.125 1.125 0 0 1 1.592 0L21.75 12M4.5 9.75V19.5A1.5 1.5 0 0 0 6 21h3.75v-5.25a1.5 1.5 0 0 1 1.5-1.5h1.5a1.5 1.5 0 0 1 1.5 1.5V21H18a1.5 1.5 0 0 0 1.5-1.5V9.75" /></svg></a>
                    <button type="button" class="flex h-10 w-full items-center justify-center rounded-lg {{ $questionGroupActive ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="{{ __('প্রশ্ন ভান্ডার') }}" @mouseenter="clearTimeout(flyoutCloseTimer); activeFlyout = 'question-bank'" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click="activeFlyout = activeFlyout === 'question-bank' ? null : 'question-bank'"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 7.5A2.25 2.25 0 0 1 6 5.25h3.19a2.25 2.25 0 0 1 1.59.66l.66.66a2.25 2.25 0 0 0 1.59.66H18A2.25 2.25 0 0 1 20.25 9.5v7A2.25 2.25 0 0 1 18 18.75H6A2.25 2.25 0 0 1 3.75 16.5v-9Z" /></svg></button>
                    <a href="{{ route('questions.set.create') }}" class="flex h-10 items-center justify-center rounded-lg {{ request()->routeIs('questions.set.create.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="Question Create" wire:navigate><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" /></svg></a>
                    @if(auth()->user()->hasRole(['teacher', 'admin', 'super_admin']))<a href="{{ route('omr.generator') }}" class="flex h-10 items-center justify-center rounded-lg {{ request()->routeIs('omr.generator') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="OMR Generator" wire:navigate><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125H5.625A1.125 1.125 0 0 1 4.5 20.625V8.625c0-.621.504-1.125 1.125-1.125H9.75" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 3.75H10.875A1.125 1.125 0 0 0 9.75 4.875v9.75c0 .621.504 1.125 1.125 1.125H18.75c.621 0 1.125-.504 1.125-1.125V8.625L15 3.75Z" /></svg></a>@endif
                    @if(auth()->user()->hasPermission('users.manage_roles'))<button type="button" class="flex h-10 w-full items-center justify-center rounded-lg {{ $adminGroupActive ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="Administration" @mouseenter="clearTimeout(flyoutCloseTimer); activeFlyout = 'admin'" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click="activeFlyout = activeFlyout === 'admin' ? null : 'admin'"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3.171A1.5 1.5 0 0 1 10.95 2.25h2.1a1.5 1.5 0 0 1 1.382.921l.229.551a1.5 1.5 0 0 0 1.123.9l.592.1a1.5 1.5 0 0 1 1.189 1.188l.1.593a1.5 1.5 0 0 0 .9 1.122l.55.23a1.5 1.5 0 0 1 .922 1.382v2.1a1.5 1.5 0 0 1-.921 1.382l-.551.229a1.5 1.5 0 0 0-.9 1.123l-.1.592a1.5 1.5 0 0 1-1.188 1.189l-.593.1a1.5 1.5 0 0 0-1.122.9l-.23.55a1.5 1.5 0 0 1-1.382.922h-2.1a1.5 1.5 0 0 1-1.382-.921l-.229-.551a1.5 1.5 0 0 0-1.123-.9l-.592-.1a1.5 1.5 0 0 1-1.189-1.188l-.1-.593a1.5 1.5 0 0 0-.9-1.122l-.55-.23a1.5 1.5 0 0 1-.922-1.382v-2.1a1.5 1.5 0 0 1 .921-1.382l.551-.229a1.5 1.5 0 0 0 .9-1.123l.1-.592a1.5 1.5 0 0 1 1.188-1.189l.593-.1a1.5 1.5 0 0 0 1.122-.9l.23-.55Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" /></svg></button>@endif
                </div>
            </template>

            <div x-show="sidebarCollapsed && activeFlyout === 'question-bank'" x-transition @mouseenter="clearTimeout(flyoutCloseTimer)" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click.outside="activeFlyout = null" class="absolute left-full top-16 z-[70] ml-2 w-48 rounded-xl border border-zinc-200 bg-white p-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900" data-test="sidebar-flyout-panel">
                <p class="mb-2 text-sm font-semibold">{{ __('প্রশ্ন ভান্ডার') }}</p>
                <div class="space-y-1 text-sm">
                    @foreach($questionGroupItems as $item)
                        @if($item['visible'])
                            <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ $item['label'] }}</a>
                        @endif
                    @endforeach
                </div>
            </div>

            @if(auth()->user()->hasPermission('users.manage_roles'))
                <div x-show="sidebarCollapsed && activeFlyout === 'admin'" x-transition @mouseenter="clearTimeout(flyoutCloseTimer)" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click.outside="activeFlyout = null" class="absolute left-full top-52 z-[70] ml-2 w-48 rounded-xl border border-zinc-200 bg-white p-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                    <p class="mb-2 text-sm font-semibold">{{ __('Administration') }}</p>
                    <div class="space-y-1 text-sm">
                        @foreach($adminItems as $item)
                            @if($item['visible'])
                                <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ $item['label'] }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </nav>

        <div class="mt-auto border-t border-zinc-200 p-3 dark:border-[var(--app-dark-border)]">
            <div x-show="! sidebarCollapsed"><x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" /></div>
            <div x-show="sidebarCollapsed" class="relative flex justify-center" @click.outside="collapsedProfileMenuOpen = false">
                <button
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-200 text-xs font-semibold text-zinc-800 transition hover:bg-zinc-300 dark:bg-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-600"
                    @click="collapsedProfileMenuOpen = ! collapsedProfileMenuOpen"
                    data-test="collapsed-profile-menu-button"
                    title="{{ auth()->user()->name }}"
                >
                    {{ auth()->user()->initials() }}
                </button>

                <div
                    x-show="collapsedProfileMenuOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-x-1 scale-95"
                    x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-x-1 scale-95"
                    class="absolute bottom-0 left-full z-[80] ml-2 w-56 rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-700 dark:bg-zinc-900"
                    data-test="collapsed-profile-menu-panel"
                >
                    <div class="mb-2 flex items-center gap-2 rounded-lg px-2 py-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-md bg-zinc-200 text-xs font-semibold text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100">{{ auth()->user()->initials() }}</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="mb-1 flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 1115 0 7.5 7.5 0 01-15 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v3.75l2.25 2.25"/></svg>
                        {{ __('Settings') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 12h9m0 0l-3-3m3 3l-3 3"/></svg>
                            {{ __('Log out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <div class="relative min-h-screen flex-1" :class="sidebarCollapsed ? 'lg:pl-16' : 'lg:pl-72'">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-200 bg-zinc-50/95 px-4 py-3 backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:hidden">
            <button type="button" class="inline-flex items-center rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = true" aria-label="Open mobile menu">☰</button>
            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-md border border-zinc-300 px-2 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" data-test="logout-button">{{ __('Log out') }}</button></form>
        </header>

        <button type="button" class="fixed bottom-5 left-3 z-40 rounded-full border border-zinc-300 bg-white p-3 shadow-lg dark:border-zinc-700 dark:bg-zinc-900 lg:hidden" @click="mobileSidebarOpen = true" x-show="! mobileSidebarOpen" data-test="mobile-sidebar-trigger" aria-label="Open sidebar">☰</button>

        <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/45 backdrop-blur-[1px] lg:hidden" @click="mobileSidebarOpen = false"></div>

        <aside x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-[86%] max-w-80 overflow-y-auto border-e border-zinc-200 bg-zinc-50 p-3 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:hidden">
            <div class="mb-4 flex items-center justify-between">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <button type="button" class="rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = false" aria-label="Close sidebar">✕</button>
            </div>

            <nav class="space-y-2 text-sm">
                @foreach($singleItems as $item)
                    @if($item['visible'])
                        <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ $item['label'] }}</a>
                    @endif
                @endforeach

                <div x-data="{ mobileQuestionsOpen: {{ $questionGroupExpanded ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="mobileQuestionsOpen ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                    <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 font-medium" @click="mobileQuestionsOpen = ! mobileQuestionsOpen">
                        <span>{{ __('প্রশ্ন ভান্ডার') }}</span>
                        <svg class="h-4 w-4 transition" :class="mobileQuestionsOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </button>
                    <div x-show="mobileQuestionsOpen" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 dark:border-zinc-700">
                        @foreach($questionGroupItems as $item)
                            @if($item['visible'])
                                <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ $item['label'] }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

                @if(auth()->user()->hasPermission('users.manage_roles'))
                    <div x-data="{ mobileAdminOpen: {{ $adminGroupExpanded ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="mobileAdminOpen ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                        <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 font-medium" @click="mobileAdminOpen = ! mobileAdminOpen">
                            <span>{{ __('Administration') }}</span>
                            <svg class="h-4 w-4 transition" :class="mobileAdminOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </button>
                        <div x-show="mobileAdminOpen" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 dark:border-zinc-700">
                            @foreach($adminItems as $item)
                                @if($item['visible'])
                                    <a href="{{ route($item['route']) }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ $item['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </nav>
        </aside>

        <header class="sticky top-0 z-30 hidden items-center justify-between border-b border-zinc-200 bg-white/95 px-5 py-3 backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:flex" data-test="sticky-page-header">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $pageTitle }}</h1>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    class="rounded-lg border border-zinc-200 p-2 text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800"
                    @click="toggleTheme()"
                    :title="theme === 'dark' ? 'Switch to Light' : 'Switch to Dark'"
                    data-test="theme-toggle-button"
                >
                    <svg x-show="theme === 'dark'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" /></svg>
                    <svg x-show="theme === 'light'" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2M4.93 4.93l1.41 1.41m11.32 11.32l1.41 1.41M2 12h2m16 0h2M4.93 19.07l1.41-1.41m11.32-11.32l1.41-1.41"/></svg>
                </button>

                <div class="relative" @click.outside="profileMenuOpen = false">
                    <button
                        type="button"
                        class="flex items-center gap-2 rounded-lg border border-zinc-200 px-2 py-1.5 hover:bg-zinc-100 dark:border-zinc-700 dark:hover:bg-zinc-800"
                        @click="profileMenuOpen = ! profileMenuOpen"
                        data-test="profile-dropdown-button"
                    >
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-200 text-xs font-semibold text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100">{{ auth()->user()->initials() }}</span>
                        <span class="text-sm font-semibold text-zinc-700 dark:text-zinc-100">{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4 text-zinc-500 transition" :class="profileMenuOpen ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </button>

                    <div
                        x-show="profileMenuOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1"
                        class="absolute right-0 z-50 mt-2 w-64 rounded-xl border border-zinc-200 bg-white p-2 shadow-xl dark:border-zinc-700 dark:bg-zinc-900"
                    >
                        <div class="mb-2 flex items-center gap-2 rounded-lg px-2 py-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-md bg-zinc-200 text-xs font-semibold text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100">{{ auth()->user()->initials() }}</span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</p>
                                <p class="truncate text-xs text-zinc-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <a href="{{ route('profile.edit') }}" class="mb-1 flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.983 5.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m17.071-7.071l-1.414 1.414M6.343 17.657l-1.414 1.414m0-14.142l1.414 1.414m11.314 11.314l1.414 1.414"/></svg>
                            {{ __('Settings') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 12h9m0 0l-3-3m3 3l-3 3"/></svg>
                                {{ __('Log out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="relative">
            <div x-show="pageLoading" x-transition.opacity class="absolute inset-0 z-[80] flex items-center justify-center bg-white/65 backdrop-blur-sm dark:bg-zinc-900/70" data-test="page-loading-overlay">
                <div class="flex items-center gap-2 rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-medium text-zinc-700 shadow-lg dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-100">
                    <svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="9" class="opacity-20" stroke="currentColor" stroke-width="3"></circle>
                        <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                    </svg>
                    <span>{{ __('Loading...') }}</span>
                </div>
            </div>

            {{ $slot }}
        </main>
    </div>
</div>

@fluxScripts
@stack('scripts')
</body>
</html>

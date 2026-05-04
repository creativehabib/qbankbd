@php
    $menuItems = [
        [
            'type' => 'link',
            'label' => __('Dashboard'),
            'route' => 'dashboard',
            'match' => 'dashboard',
            'icon' => 'home',
            'visible' => true,
        ],
        [
            'type' => 'group',
            'label' => __('প্রশ্ন ভান্ডার'),
            'icon' => 'circle-stack',
            'flyout' => 'question-bank',
            'active' => request()->routeIs(['questions.*', 'exam-categories.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*']),
            'visible' => true,
            'items' => [
                ['label' => __('Questions'), 'route' => 'questions.index', 'match' => 'questions.*', 'visible' => true],
                ['label' => __('Exam Categories'), 'route' => 'exam-categories.index', 'match' => 'exam-categories.*', 'visible' => auth()->user()->hasAnyPermission(['exam_categories.manage'])],
                ['label' => __('Academic Class'), 'route' => 'academic-classes.index', 'match' => 'academic-classes.*', 'visible' => auth()->user()->hasAnyPermission(['academic_classes.manage'])],
                ['label' => __('Subjects'), 'route' => 'subjects.index', 'match' => 'subjects.*', 'visible' => auth()->user()->hasAnyPermission(['subjects.manage'])],
                ['label' => __('Chapter'), 'route' => 'chapters.index', 'match' => 'chapters.*', 'visible' => auth()->user()->hasAnyPermission(['chapters.manage'])],
                ['label' => __('Topics'), 'route' => 'topics.index', 'match' => 'topics.*', 'visible' => auth()->user()->hasAnyPermission(['topics.manage'])],
                ['label' => __('Tags'), 'route' => 'tags.index', 'match' => 'tags.*', 'visible' => auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete'])],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Question Create'),
            'route' => 'question.set-create',
            'match' => 'question.set-create',
            'icon' => 'plus-circle',
            'visible' => true,
        ],
        [
            'type' => 'link',
            'label' => __('আমার তৈরি প্রশ্ন'),
            'route' => 'teacher.questions.index',
            'match' => 'teacher.questions.index',
            'icon' => 'document-text',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('OMR Generator'),
            'route' => 'omr.generator',
            'match' => 'omr.generator',
            'icon' => 'document-duplicate',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
        ],
        [
            'type' => 'link',
            'label' => __('প্রতিষ্ঠানের তথ্য'),
            'route' => 'teacher.institution-info',
            'match' => 'teacher.institution-info',
            'icon' => 'building-office',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('আমার সাবস্ক্রিপশন'),
            'route' => 'teacher.subscription',
            'match' => 'teacher.subscription',
            'icon' => 'book-open',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('প্রাইসিং'),
            'route' => 'teacher.pricing',
            'match' => 'teacher.pricing',
            'icon' => 'currency-dollar',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('আমার উপার্জন'),
            'route' => 'teacher.earnings',
            'match' => 'teacher.earnings',
            'icon' => 'banknotes',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('রিচার্জ/উইথড্র'),
            'route' => 'teacher.wallet',
            'match' => 'teacher.wallet',
            'icon' => 'wallet',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('Practice'),
            'route' => 'students.practice.index',
            'match' => 'students.practice.*',
            'icon' => 'academic-cap',
            'visible' => auth()->user()->isStudent(),
        ],
        [
            'type' => 'link',
            'label' => __('Bookmarks'),
            'route' => 'student.bookmarks',
            'match' => 'student.bookmarks',
            'icon' => 'bookmark',
            'visible' => auth()->user()->isStudent(),
        ],
        [
            'type' => 'group',
            'label' => __('Administration'),
            'icon' => 'cog-8-tooth',
            'flyout' => 'admin',
            'active' => request()->routeIs(['users.*', 'admin.theme-options', 'admin.wallet-approvals', 'admin.packages', 'permissions.*', 'roles-permissions.*']),
            'visible' => auth()->user()->hasPermission('users.manage_roles') || auth()->user()->hasPermission('users.manage_permissions'),
            'items' => [
                ['label' => __('User Management'), 'route' => 'users.index', 'match' => 'users.*', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Theme Options'), 'route' => 'admin.theme-options', 'match' => 'admin.theme-options', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Wallet Approvals'), 'route' => 'admin.wallet-approvals', 'match' => 'admin.wallet-approvals', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Package Management'), 'route' => 'admin.packages', 'match' => 'admin.packages', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Permissions'), 'route' => 'permissions.index', 'match' => 'permissions.*', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
                ['label' => __('Roles & Permissions'), 'route' => 'roles-permissions.index', 'match' => 'roles-permissions.*', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Leaderboard'),
            'route' => 'student.leaderboard',
            'match' => 'student.leaderboard',
            'icon' => 'trophy', // Heroicon name
            'visible' => auth()->user()->isStudent(),
        ],
    ];

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
    <!-- Desktop Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-40 hidden flex-col border-e border-zinc-200 bg-zinc-50 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:flex" :class="sidebarCollapsed ? 'w-16' : 'w-72'" data-test="desktop-sidebar">
        <div class="flex items-center justify-between border-b border-zinc-200 px-3 py-3 dark:border-[var(--app-dark-border)]">
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate x-show="! sidebarCollapsed" />
            <button type="button" class="rounded-md border border-zinc-300 p-2 text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800" @click="sidebarCollapsed = ! sidebarCollapsed" data-test="sidebar-collapse-button" title="Toggle sidebar">
                <x-heroicon-o-bars-3-bottom-left class="size-5" />
            </button>
        </div>

        <nav class="relative flex-1 space-y-2 p-2" :class="sidebarCollapsed ? 'overflow-visible' : 'overflow-y-auto'" data-test="sidebar-nav">

            <!-- Full Sidebar Menu -->
            <template x-if="! sidebarCollapsed">
                <div class="space-y-2">
                    @foreach($menuItems as $item)
                        @if($item['visible'])
                            @if($item['type'] === 'link')
                                <a href="{{ route($item['route']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-200' }}" wire:navigate>
                                    <span class="inline-flex h-5 w-5 items-center justify-center opacity-80">
                                        <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                    </span>
                                    <span>{{ $item['label'] }}</span>
                                </a>
                            @elseif($item['type'] === 'group')
                                <div x-data="{ open: {{ $item['active'] ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="open ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                                    <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold hover:bg-zinc-200 dark:hover:bg-zinc-800" @click="open = ! open">
                                        <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400">
                                            <span class="inline-flex h-5 w-5 items-center justify-center opacity-90">
                                                <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                            </span>
                                            <span class="text-zinc-800 dark:text-zinc-100">{{ $item['label'] }}</span>
                                        </div>
                                        <x-heroicon-o-chevron-down class="size-4 text-zinc-500 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                                    </button>
                                    <div x-show="open" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 mt-1 dark:border-zinc-700">
                                        @foreach($item['items'] as $subItem)
                                            @if($subItem['visible'])
                                                <a href="{{ route($subItem['route']) }}" class="block rounded-md px-2 py-1.5 text-sm {{ request()->routeIs($subItem['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}" wire:navigate>{{ $subItem['label'] }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </template>

            <!-- Collapsed Sidebar Menu -->
            <template x-if="sidebarCollapsed">
                <div class="space-y-2">
                    @foreach($menuItems as $item)
                        @if($item['visible'])
                            @if($item['type'] === 'link')
                                <a href="{{ route($item['route']) }}" class="flex h-10 items-center justify-center rounded-lg {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}" title="{{ $item['label'] }}" wire:navigate>
                                    <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                </a>
                            @elseif($item['type'] === 'group')
                                <div class="relative">
                                    <button type="button" class="flex h-10 w-full items-center justify-center rounded-lg {{ $item['active'] ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-emerald-600 dark:text-emerald-400' }}" title="{{ $item['label'] }}" @mouseenter="clearTimeout(flyoutCloseTimer); activeFlyout = '{{ $item['flyout'] }}'" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click="activeFlyout = activeFlyout === '{{ $item['flyout'] }}' ? null : '{{ $item['flyout'] }}'">
                                        <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                    </button>

                                    <div x-show="activeFlyout === '{{ $item['flyout'] }}'" x-transition @mouseenter="clearTimeout(flyoutCloseTimer)" @mouseleave="flyoutCloseTimer = setTimeout(() => activeFlyout = null, 140)" @click.outside="activeFlyout = null" class="absolute left-full top-0 z-[70] ml-2 w-48 rounded-xl border border-zinc-200 bg-white p-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900" style="display:none;">
                                        <p class="mb-2 text-sm font-semibold">{{ $item['label'] }}</p>
                                        <div class="space-y-1 text-sm">
                                            @foreach($item['items'] as $subItem)
                                                @if($subItem['visible'])
                                                    <a href="{{ route($subItem['route']) }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs($subItem['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}" wire:navigate>{{ $subItem['label'] }}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            </template>
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
                        <x-heroicon-o-cog-8-tooth class="size-4" />
                        {{ __('Settings') }}
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                            <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
                            {{ __('Log out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobile Header & Main Content Area -->
    <div class="relative min-h-screen flex-1" :class="sidebarCollapsed ? 'lg:pl-16' : 'lg:pl-72'">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-200 bg-zinc-50/95 px-4 py-3 print:hidden backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:hidden">
            <button type="button" class="inline-flex items-center rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = true" aria-label="Open mobile menu">
                <x-heroicon-o-bars-3 class="size-5" />
            </button>
            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-md border border-zinc-300 px-2 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" data-test="logout-button">{{ __('Log out') }}</button></form>
        </header>

        <button type="button" class="fixed bottom-5 left-3 z-40 rounded-full border print:hidden border-zinc-300 bg-white p-3 shadow-lg dark:border-zinc-700 dark:bg-zinc-900 lg:hidden" @click="mobileSidebarOpen = true" x-show="! mobileSidebarOpen" data-test="mobile-sidebar-trigger" aria-label="Open sidebar">
            <x-heroicon-o-bars-3 class="size-6" />
        </button>

        <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/45 backdrop-blur-[1px] lg:hidden" @click="mobileSidebarOpen = false"></div>

        <aside x-show="mobileSidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 w-[86%] max-w-80 overflow-y-auto border-e border-zinc-200 bg-zinc-50 p-3 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:hidden">
            <div class="mb-4 flex items-center justify-between">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <button type="button" class="rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = false" aria-label="Close sidebar">✕</button>
            </div>

            <nav class="space-y-2 text-sm">
                @foreach($menuItems as $item)
                    @if($item['visible'])
                        @if($item['type'] === 'link')
                            <a href="{{ route($item['route']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm {{ request()->routeIs($item['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-200' }}" wire:navigate>
                                <span class="inline-flex h-5 w-5 items-center justify-center opacity-80">
                                    <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        @elseif($item['type'] === 'group')
                            <div x-data="{ open: {{ $item['active'] ? 'true' : 'false' }} }" class="rounded-lg p-1" :class="open ? 'border border-zinc-200 dark:border-zinc-700' : ''">
                                <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold hover:bg-zinc-200 dark:hover:bg-zinc-800" @click="open = ! open">
                                    <div class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400">
                                        <span class="inline-flex h-5 w-5 items-center justify-center opacity-90">
                                            <x-dynamic-component :component="'heroicon-o-' . $item['icon']" class="size-5" />
                                        </span>
                                        <span class="text-zinc-800 dark:text-zinc-100">{{ $item['label'] }}</span>
                                    </div>
                                    <x-heroicon-o-chevron-down class="size-4 text-zinc-500 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                                </button>
                                <div x-show="open" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 mt-1 dark:border-zinc-700">
                                    @foreach($item['items'] as $subItem)
                                        @if($subItem['visible'])
                                            <a href="{{ route($subItem['route']) }}" class="block rounded-md px-2 py-1.5 text-sm {{ request()->routeIs($subItem['match']) ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800 text-zinc-600 dark:text-zinc-300' }}" wire:navigate>{{ $subItem['label'] }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </nav>
        </aside>

        <!-- Top Header Navigation -->
        <header class="sticky top-0 z-30 hidden items-center justify-between border-b border-zinc-200 bg-white/95 px-5 py-2 backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:flex" data-test="sticky-page-header">
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
                    <x-heroicon-o-sun x-show="theme === 'dark'" class="size-5" />
                    <x-heroicon-o-moon x-show="theme === 'light'" class="size-5" />
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
                        <x-heroicon-o-chevron-down class="size-4 text-zinc-500 transition-transform" x-bind:class="profileMenuOpen ? 'rotate-180' : ''" />
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
                            <x-heroicon-o-cog-8-tooth class="size-4" />
                            {{ __('Settings') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-heroicon-o-arrow-right-on-rectangle class="size-4" />
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

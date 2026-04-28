<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        mobileSidebarOpen: false,
        sidebarCollapsed: JSON.parse(localStorage.getItem('sidebar-collapsed') ?? 'false'),
        activeFlyout: null
    }"
    x-init="$watch('sidebarCollapsed', (value) => { localStorage.setItem('sidebar-collapsed', JSON.stringify(value)); if (! value) { activeFlyout = null; } })"
    class="min-h-screen bg-gray-50 print:bg-white dark:bg-[var(--app-dark-bg)]"
>
<div class="flex min-h-screen">
    <aside
        class="fixed inset-y-0 left-0 z-40 hidden flex-col border-e border-zinc-200 bg-zinc-50 transition-all duration-200 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:flex"
        :class="sidebarCollapsed ? 'w-16' : 'w-72'"
        data-test="desktop-sidebar"
    >
        <div class="flex items-center justify-between border-b border-zinc-200 px-3 py-3 dark:border-[var(--app-dark-border)]">
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate x-show="! sidebarCollapsed" />
            <button
                type="button"
                class="rounded-md border border-zinc-300 p-2 text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800"
                @click="sidebarCollapsed = ! sidebarCollapsed"
                data-test="sidebar-collapse-button"
                title="Toggle sidebar"
            >
                <span x-show="! sidebarCollapsed">◧</span>
                <span x-show="sidebarCollapsed">◨</span>
            </button>
        </div>

        <nav class="relative flex-1 space-y-2 overflow-y-auto p-2" data-test="sidebar-nav">
            <template x-if="! sidebarCollapsed">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-white ring-1 ring-zinc-200 dark:bg-zinc-900 dark:ring-zinc-700' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>🏠 {{ __('Dashboard') }}</a>

                    <div x-data="{ open: {{ request()->routeIs(['questions.*', 'exam-categories.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*']) ? 'true' : 'false' }} }" class="rounded-lg border border-blue-500/70 bg-white/70 p-1 dark:border-blue-400 dark:bg-zinc-900/70">
                        <button type="button" class="flex w-full items-center justify-between rounded-md px-2 py-2 text-sm font-semibold" @click="open = ! open">
                            <span>🗂 {{ __('প্রশ্ন ভান্ডার') }}</span>
                            <span :class="open ? 'rotate-180' : ''" class="transition">⌄</span>
                        </button>
                        <div x-show="open" x-collapse class="space-y-1 border-s border-zinc-200 ps-3 dark:border-zinc-700">
                            <a href="{{ route('questions.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('questions.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Questions') }}</a>
                            @if(auth()->user()->hasAnyPermission(['exam_categories.manage']))<a href="{{ route('exam-categories.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('exam-categories.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Exam Categories') }}</a>@endif
                            @if(auth()->user()->hasAnyPermission(['academic_classes.manage']))<a href="{{ route('academic-classes.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('academic-classes.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Academic Class') }}</a>@endif
                            @if(auth()->user()->hasAnyPermission(['subjects.manage']))<a href="{{ route('subjects.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('subjects.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Subjects') }}</a>@endif
                            @if(auth()->user()->hasAnyPermission(['chapters.manage']))<a href="{{ route('chapters.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('chapters.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Chapter') }}</a>@endif
                            @if(auth()->user()->hasAnyPermission(['topics.manage']))<a href="{{ route('topics.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('topics.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Topics') }}</a>@endif
                            @if(auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']))<a href="{{ route('tags.index') }}" class="block rounded-md px-2 py-1.5 {{ request()->routeIs('tags.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Tags') }}</a>@endif
                        </div>
                    </div>

                    <a href="{{ route('questions.set.create') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('Question Create') }}</a>
                    @if(auth()->user()->hasRole(['teacher', 'admin', 'super_admin']))<a href="{{ route('omr.generator') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('omr.generator') ? 'bg-white ring-1 ring-zinc-200 dark:bg-zinc-900 dark:ring-zinc-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('OMR Generator') }}</a>@endif
                    @if(auth()->user()->isStudent())<a href="{{ route('students.practice.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('Practice') }}</a>@endif

                    @if(auth()->user()->hasPermission('users.manage_roles'))
                        <div class="space-y-1 rounded-lg p-1">
                            <p class="px-2 text-xs font-semibold text-zinc-500">{{ __('Administration') }}</p>
                            <a href="{{ route('users.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('User Management') }}</a>
                            <a href="{{ route('admin.theme-options') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('Theme Options') }}</a>
                            @if(auth()->user()->hasPermission('users.manage_permissions'))
                                <a href="{{ route('permissions.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('Permissions') }}</a>
                                <a href="{{ route('roles-permissions.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-200 dark:hover:bg-zinc-800" wire:navigate>{{ __('Roles & Permissions') }}</a>
                            @endif
                        </div>
                    @endif
                </div>
            </template>

            <template x-if="sidebarCollapsed">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex h-10 items-center justify-center rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white ring-1 ring-zinc-200 dark:bg-zinc-900 dark:ring-zinc-700' : 'hover:bg-zinc-200 dark:hover:bg-zinc-800' }}" title="Dashboard" wire:navigate>🏠</a>

                    <button type="button" class="flex h-10 w-full items-center justify-center rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800" title="{{ __('প্রশ্ন ভান্ডার') }}" @click="activeFlyout = activeFlyout === 'question-bank' ? null : 'question-bank'">🗂</button>
                    <a href="{{ route('questions.set.create') }}" class="flex h-10 items-center justify-center rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800" title="Question Create" wire:navigate>➕</a>
                    @if(auth()->user()->hasRole(['teacher', 'admin', 'super_admin']))<a href="{{ route('omr.generator') }}" class="flex h-10 items-center justify-center rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800" title="OMR Generator" wire:navigate>📄</a>@endif
                    @if(auth()->user()->hasPermission('users.manage_roles'))<button type="button" class="flex h-10 w-full items-center justify-center rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800" title="Administration" @click="activeFlyout = activeFlyout === 'admin' ? null : 'admin'">🛡</button>@endif
                    <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="mt-3 flex h-10 items-center justify-center rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800" title="Documentation">📘</a>
                </div>
            </template>

            <div
                x-show="sidebarCollapsed && activeFlyout === 'question-bank'"
                x-transition
                @click.outside="activeFlyout = null"
                class="absolute left-14 top-16 z-50 w-48 rounded-xl border border-zinc-200 bg-white p-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900"
                data-test="sidebar-flyout-panel"
            >
                <p class="mb-2 text-sm font-semibold">{{ __('প্রশ্ন ভান্ডার') }}</p>
                <div class="space-y-1 text-sm">
                    <a href="{{ route('questions.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Questions') }}</a>
                    @if(auth()->user()->hasAnyPermission(['exam_categories.manage']))<a href="{{ route('exam-categories.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Exam Categories') }}</a>@endif
                    @if(auth()->user()->hasAnyPermission(['academic_classes.manage']))<a href="{{ route('academic-classes.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Academic Class') }}</a>@endif
                    @if(auth()->user()->hasAnyPermission(['subjects.manage']))<a href="{{ route('subjects.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Subjects') }}</a>@endif
                    @if(auth()->user()->hasAnyPermission(['chapters.manage']))<a href="{{ route('chapters.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Chapter') }}</a>@endif
                    @if(auth()->user()->hasAnyPermission(['topics.manage']))<a href="{{ route('topics.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Topics') }}</a>@endif
                    @if(auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']))<a href="{{ route('tags.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Tags') }}</a>@endif
                </div>
            </div>

            @if(auth()->user()->hasPermission('users.manage_roles'))
                <div x-show="sidebarCollapsed && activeFlyout === 'admin'" x-transition @click.outside="activeFlyout = null" class="absolute left-14 top-52 z-50 w-48 rounded-xl border border-zinc-200 bg-white p-3 shadow-xl dark:border-zinc-700 dark:bg-zinc-900">
                    <p class="mb-2 text-sm font-semibold">{{ __('Administration') }}</p>
                    <div class="space-y-1 text-sm">
                        <a href="{{ route('users.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('User Management') }}</a>
                        <a href="{{ route('admin.theme-options') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Theme Options') }}</a>
                        @if(auth()->user()->hasPermission('users.manage_permissions'))
                            <a href="{{ route('permissions.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Permissions') }}</a>
                            <a href="{{ route('roles-permissions.index') }}" class="block rounded-md px-2 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Roles & Permissions') }}</a>
                        @endif
                    </div>
                </div>
            @endif
        </nav>

        <div class="mt-auto border-t border-zinc-200 p-3 dark:border-[var(--app-dark-border)]">
            <div x-show="! sidebarCollapsed">
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            </div>
            <div x-show="sidebarCollapsed" class="flex justify-center">
                <a href="{{ route('profile.edit') }}" class="flex h-8 w-8 items-center justify-center rounded-md bg-zinc-200 text-xs font-semibold text-zinc-800 dark:bg-zinc-700 dark:text-zinc-100" wire:navigate title="{{ auth()->user()->name }}">{{ auth()->user()->initials() }}</a>
            </div>
        </div>
    </aside>

    <div class="min-h-screen flex-1 transition-all duration-200" :class="sidebarCollapsed ? 'lg:pl-16' : 'lg:pl-72'">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-200 bg-zinc-50/95 px-4 py-3 backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:hidden">
            <button type="button" class="inline-flex items-center rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = true">☰</button>
            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-md border border-zinc-300 px-2 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" data-test="logout-button">{{ __('Log out') }}</button></form>
        </header>

        <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="mobileSidebarOpen = false"></div>

        <aside x-show="mobileSidebarOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto border-e border-zinc-200 bg-zinc-50 p-3 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:hidden">
            <div class="mb-3 flex items-center justify-between"><x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate /><button type="button" class="rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = false">✕</button></div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Dashboard') }}</a>
                <a href="{{ route('questions.index') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Questions') }}</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Settings') }}</a>
            </div>
        </aside>

        <main>{{ $slot }}</main>
    </div>
</div>

@fluxScripts
@stack('scripts')
</body>
</html>

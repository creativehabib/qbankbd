<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        mobileSidebarOpen: false,
        sidebarCollapsed: JSON.parse(localStorage.getItem('sidebar-collapsed') ?? 'false')
    }"
    x-init="$watch('sidebarCollapsed', (value) => localStorage.setItem('sidebar-collapsed', JSON.stringify(value)))"
    class="min-h-screen bg-gray-50 print:bg-white dark:bg-[var(--app-dark-bg)]"
>
<div class="flex min-h-screen">
    <aside
        class="fixed inset-y-0 left-0 z-40 hidden flex-col border-e border-zinc-200 bg-zinc-50 transition-all duration-200 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:flex"
        :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        data-test="desktop-sidebar"
    >
        <div class="flex items-center justify-between border-b border-zinc-200 px-3 py-3 dark:border-[var(--app-dark-border)]">
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <button
                type="button"
                class="rounded-md border border-zinc-300 px-2 py-1 text-xs text-zinc-700 transition hover:bg-zinc-100 dark:border-zinc-700 dark:text-zinc-100 dark:hover:bg-zinc-800"
                @click="sidebarCollapsed = ! sidebarCollapsed"
                data-test="sidebar-collapse-button"
            >
                <span x-show="! sidebarCollapsed">{{ __('Minimize') }}</span>
                <span x-show="sidebarCollapsed">→</span>
            </button>
        </div>

        <nav class="flex-1 space-y-2 overflow-y-auto px-3 py-4" data-test="sidebar-nav">
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}"
                :class="sidebarCollapsed ? 'justify-center' : 'justify-start gap-2'"
                wire:navigate
                title="Dashboard"
            >
                <span>🏠</span>
                <span x-show="! sidebarCollapsed">{{ __('Dashboard') }}</span>
            </a>

            <div
                x-data="{ open: {{ request()->routeIs(['questions.*', 'exam-categories.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*']) ? 'true' : 'false' }} }"
                class="rounded-xl border border-zinc-200/80 p-1 dark:border-zinc-800"
            >
                <button
                    type="button"
                    class="flex w-full items-center rounded-lg px-3 py-2 text-left text-sm font-semibold text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800"
                    :class="sidebarCollapsed ? 'justify-center' : 'justify-between'"
                    @click="if (sidebarCollapsed) { sidebarCollapsed = false; open = true; } else { open = ! open; }"
                    title="{{ __('প্রশ্ন ভান্ডার') }}"
                >
                    <span x-show="! sidebarCollapsed">{{ __('প্রশ্ন ভান্ডার') }}</span>
                    <span x-show="sidebarCollapsed">📚</span>
                    <svg x-show="! sidebarCollapsed" class="h-4 w-4 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="open && ! sidebarCollapsed" x-collapse class="mt-1 space-y-1 px-1 pb-1">
                    <a href="{{ route('questions.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('questions.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Questions') }}</a>

                    @if(auth()->user()->hasAnyPermission(['exam_categories.manage']))
                        <a href="{{ route('exam-categories.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('exam-categories.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Exam Categories') }}</a>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['academic_classes.manage']))
                        <a href="{{ route('academic-classes.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('academic-classes.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Academic Class') }}</a>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['subjects.manage']))
                        <a href="{{ route('subjects.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('subjects.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Subjects') }}</a>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['chapters.manage']))
                        <a href="{{ route('chapters.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('chapters.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Chapter') }}</a>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['topics.manage']))
                        <a href="{{ route('topics.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('topics.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Topics') }}</a>
                    @endif
                    @if(auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']))
                        <a href="{{ route('tags.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('tags.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Tags') }}</a>
                    @endif
                </div>
            </div>

            <a href="{{ route('questions.set.create') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('questions.set.create.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate x-show="! sidebarCollapsed">{{ __('Question Create') }}</a>

            @if(auth()->user()->hasRole(['teacher', 'admin', 'super_admin']))
                <a href="{{ route('omr.generator') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('omr.generator') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate x-show="! sidebarCollapsed">{{ __('OMR Generator') }}</a>
            @endif

            @if(auth()->user()->isStudent())
                <a href="{{ route('students.practice.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('students.practice.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate x-show="! sidebarCollapsed">{{ __('Practice') }}</a>
            @endif

            @if(auth()->user()->hasPermission('users.manage_roles'))
                <div class="space-y-1 rounded-xl border border-zinc-200/80 p-2 dark:border-zinc-800" x-show="! sidebarCollapsed">
                    <p class="px-2 pb-1 text-xs font-semibold uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('Administration') }}</p>
                    <a href="{{ route('users.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('users.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('User Management') }}</a>
                    <a href="{{ route('admin.theme-options') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('admin.theme-options') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Theme Options') }}</a>
                    @if(auth()->user()->hasPermission('users.manage_permissions'))
                        <a href="{{ route('permissions.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('permissions.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Permissions') }}</a>
                        <a href="{{ route('roles-permissions.index') }}" class="block rounded-lg px-3 py-2 text-sm {{ request()->routeIs('roles-permissions.*') ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900' : 'text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800' }}" wire:navigate>{{ __('Roles & Permissions') }}</a>
                    @endif
                </div>
            @endif

            <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" x-show="! sidebarCollapsed">{{ __('Documentation') }}</a>
        </nav>

        <div class="border-t border-zinc-200 p-3 dark:border-[var(--app-dark-border)]" x-show="! sidebarCollapsed">
            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </div>
    </aside>

    <div class="min-h-screen flex-1 transition-all duration-200" :class="sidebarCollapsed ? 'lg:pl-20' : 'lg:pl-72'">
        <header class="sticky top-0 z-30 flex items-center justify-between border-b border-zinc-200 bg-zinc-50/95 px-4 py-3 backdrop-blur dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]/95 lg:hidden">
            <button type="button" class="inline-flex items-center rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                ☰
            </button>
            <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->name }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-md border border-zinc-300 px-2 py-1 text-xs font-medium text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" data-test="logout-button">{{ __('Log out') }}</button>
            </form>
        </header>

        <div x-show="mobileSidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/40 lg:hidden" @click="mobileSidebarOpen = false"></div>

        <aside x-show="mobileSidebarOpen" x-transition class="fixed inset-y-0 left-0 z-50 w-72 overflow-y-auto border-e border-zinc-200 bg-zinc-50 p-3 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)] lg:hidden">
            <div class="mb-3 flex items-center justify-between">
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <button type="button" class="rounded-md border border-zinc-300 px-2 py-1 text-zinc-700 dark:border-zinc-700 dark:text-zinc-100" @click="mobileSidebarOpen = false">✕</button>
            </div>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Dashboard') }}</a>
                <a href="{{ route('questions.index') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Questions') }}</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-zinc-700 hover:bg-zinc-200 dark:text-zinc-100 dark:hover:bg-zinc-800" wire:navigate>{{ __('Settings') }}</a>
            </div>
        </aside>

        <main>
            {{ $slot }}
        </main>
    </div>
</div>

@fluxScripts
@stack('scripts')
</body>
</html>

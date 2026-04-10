<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">
<flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
        <flux:sidebar.collapse />
    </flux:sidebar.header>

    <flux:sidebar.nav class="space-y-2">
        <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
            {{ __('Dashboard') }}
        </flux:sidebar.item>

        <flux:sidebar.group
            :heading="__('প্রশ্ন ভান্ডার')"
            icon="rectangle-stack"
            expandable
            :expanded="request()->routeIs(['questions.*', 'exam-categories.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*'])"
        >

            <flux:sidebar.item icon="document-text" :href="route('questions.index')" :current="request()->routeIs('questions.*')" wire:navigate>
                {{ __('Questions') }}
            </flux:sidebar.item>

            @if(auth()->user()->hasAnyPermission(['exam_categories.manage']))
                <flux:sidebar.item icon="clipboard-document-list" :href="route('exam-categories.index')" :current="request()->routeIs('exam-categories.*')" wire:navigate>
                    {{ __('Exam Categories') }}
                </flux:sidebar.item>
            @endif
            @if(auth()->user()->hasAnyPermission(['academic_classes.manage']))
                <flux:sidebar.item icon="academic-cap" :href="route('academic-classes.index')" :current="request()->routeIs('academic-classes.*')" wire:navigate>
                    {{ __('Academic Class') }}
                </flux:sidebar.item>
            @endif
            @if(auth()->user()->hasAnyPermission(['subjects.manage']))
                <flux:sidebar.item icon="book-open" :href="route('subjects.index')" :current="request()->routeIs('subjects.*')" wire:navigate>
                    {{ __('Subjects') }}
                </flux:sidebar.item>
            @endif

            @if(auth()->user()->hasAnyPermission(['chapters.manage']))
                <flux:sidebar.item icon="bookmark" :href="route('chapters.index')" :current="request()->routeIs('chapters.*')" wire:navigate>
                    {{ __('Chapter') }}
                </flux:sidebar.item>
            @endif

            @if(auth()->user()->hasAnyPermission(['topics.manage']))
                <flux:sidebar.item icon="hashtag" :href="route('topics.index')" :current="request()->routeIs('topics.*')" wire:navigate>
                    {{ __('Topics') }}
                </flux:sidebar.item>
            @endif

            @if(auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete']))
                <flux:sidebar.item icon="tag" :href="route('tags.index')" :current="request()->routeIs('tags.*')" wire:navigate>
                    {{ __('Tags') }}
                </flux:sidebar.item>
            @endif

        </flux:sidebar.group>

        <flux:sidebar.item icon="tag" :href="route('questions.set.create')" :current="request()->routeIs('questions.set.create.*')" wire:navigate>
            {{ __('Question Create') }}
        </flux:sidebar.item>
        @if(auth()->user()->hasPermission('users.manage_roles'))
            <flux:sidebar.group :heading="__('Administration')" icon="shield-check">
                <flux:sidebar.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                    {{ __('User Management') }}
                </flux:sidebar.item>
                @if(auth()->user()->hasPermission('users.manage_permissions'))
                    <flux:sidebar.item icon="key" :href="route('permissions.index')" :current="request()->routeIs('permissions.*')" wire:navigate>
                        {{ __('Permissions') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="lock-closed" :href="route('roles-permissions.index')" :current="request()->routeIs('roles-permissions.*')" wire:navigate>
                        {{ __('Roles & Permissions') }}
                    </flux:sidebar.item>
                @endif
            </flux:sidebar.group>
        @endif

        <flux:spacer />

    </flux:sidebar.nav>

    <flux:spacer />

    <flux:sidebar.nav>
        <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
            {{ __('Documentation') }}
        </flux:sidebar.item>
    </flux:sidebar.nav>

    <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
</flux:sidebar>

<flux:header class="lg:hidden">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:spacer />

    <flux:dropdown position="top" align="end">
        <flux:profile
            :initials="auth()->user()->initials()"
            icon-trailing="chevron-down"
        />

        <flux:menu>
            <flux:menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <flux:avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                        />

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                            <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                        </div>
                    </div>
                </div>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <flux:menu.radio.group>
                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                    {{ __('Settings') }}
                </flux:menu.item>
            </flux:menu.radio.group>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </flux:menu.item>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

{{ $slot }}

@fluxScripts
</body>
</html>

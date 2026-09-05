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
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
            'items' => [
                ['label' => __('Questions'), 'route' => 'questions.index', 'match' => 'questions.*', 'icon' => 'document-text', 'visible' => true],
                ['label' => __('Exam Categories'), 'route' => 'exam-categories.index', 'match' => 'exam-categories.*', 'icon' => 'folder', 'visible' => auth()->user()->hasAnyPermission(['exam_categories.manage'])],
                ['label' => __('Academic Class'), 'route' => 'academic-classes.index', 'match' => 'academic-classes.*', 'icon' => 'academic-cap', 'visible' => auth()->user()->hasAnyPermission(['academic_classes.manage'])],
                ['label' => __('Subjects'), 'route' => 'subjects.index', 'match' => 'subjects.*', 'icon' => 'book-open', 'visible' => auth()->user()->hasAnyPermission(['subjects.manage'])],
                ['label' => __('Chapter'), 'route' => 'chapters.index', 'match' => 'chapters.*', 'icon' => 'bookmark', 'visible' => auth()->user()->hasAnyPermission(['chapters.manage'])],
                ['label' => __('Topics'), 'route' => 'topics.index', 'match' => 'topics.*', 'icon' => 'hashtag', 'visible' => auth()->user()->hasAnyPermission(['topics.manage'])],
                ['label' => __('Tags'), 'route' => 'tags.index', 'match' => 'tags.*', 'icon' => 'tag', 'visible' => auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete'])],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Question Create'),
            'route' => 'question.set-create',
            'match' => 'question.set-create',
            'icon' => 'plus-circle',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
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
            'label' => __('OMR শীট তৈরি'),
            'route' => 'omr.generator',
            'match' => 'omr.generator',
            'icon' => 'custom-omr-frame',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
        ],
        [
            'type' => 'link',
            'label' => __('OMR স্ক্যানার'),
            'route' => 'student.omr-scanner',
            'match' => 'student.omr-scanner',
            'icon' => 'viewfinder-circle',
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
            'icon' => 'shield-check',
            'flyout' => 'admin',
            'active' => request()->routeIs(['users.*', 'admin.theme-options', 'admin.wallet-approvals', 'admin.packages', 'permissions.*', 'roles-permissions.*']),
            'visible' => auth()->user()->hasPermission('users.manage_roles') || auth()->user()->hasPermission('users.manage_permissions'),
            'items' => [
                ['label' => __('User Management'), 'route' => 'users.index', 'match' => 'users.*', 'icon' => 'users', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Theme Options'), 'route' => 'admin.theme-options', 'match' => 'admin.theme-options', 'icon' => 'paint-brush', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Wallet Approvals'), 'route' => 'admin.wallet-approvals', 'match' => 'admin.wallet-approvals', 'icon' => 'banknotes', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Package Management'), 'route' => 'admin.packages', 'match' => 'admin.packages', 'icon' => 'cube', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Permissions'), 'route' => 'permissions.index', 'match' => 'permissions.*', 'icon' => 'key', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
                ['label' => __('Roles & Permissions'), 'route' => 'roles-permissions.index', 'match' => 'roles-permissions.*', 'icon' => 'lock-closed', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Leaderboard'),
            'route' => 'student.leaderboard',
            'match' => 'student.leaderboard',
            'icon' => 'trophy',
            'visible' => auth()->user()->isStudent(),
        ],
        [
            'type' => 'link',
            'label' => __('Mistake Review'),
            'route' => 'student.mistakes',
            'match' => 'student.mistakes',
            'icon' => 'exclamation-circle',
            'visible' => auth()->user()->isStudent()
        ],
        [
            'type' => 'link',
            'label' => __("Test History"),
            'route' => 'student.test-history',
            'match' => 'student.test-history',
            'icon' => 'clock',
            'visible' => auth()->user()->isStudent()
        ],
        [
            'type' => 'group',
            'label' => __('OMR'),
            'icon' => 'document-check',
            'flyout' => 'omr-bank',
            'active' => request()->routeIs(['tokens.*', 'omr.*']),
            'visible' => true,
            'items' => [
                ['label' => __('Token List'), 'route' => 'tokens.list', 'match' => 'tokens.*', 'icon' => 'ticket', 'visible' => true],
                ['label' => __('Token Map'), 'route' => 'tokens.map-answers', 'match' => 'tokens.*', 'icon' => 'map-pin', 'visible' => auth()->user()->hasAnyPermission(['tokens.map-answers'])],
                ['label' => __('OMR'), 'route' => 'omr.evaluate', 'match' => 'omr.*', 'icon' => 'check-badge', 'visible' => auth()->user()->hasAnyPermission(['omr.evaluate'])],
            ]
        ],
        [
            'type'  => 'group',
            'label' =>  __('Settings'),
            'icon'  =>  'cog-8-tooth',
            'flyout'   => 'settings',
            'active'    => request()->routeIs([]),
            'visible'   => true,
            'items'     => [
                ['label' => __('General Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'adjustments-horizontal', 'visible' => true],
                ['label' => __('Brand Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'sparkles', 'visible' => true],
                ['label' => __('Email Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'envelope', 'visible' => true],
                ['label' => __('AI Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'cpu-chip', 'visible' => true],
                ['label' => __('Languages'), 'route' => 'dashboard', 'match' => '', 'icon' => 'language', 'visible' => true],
                ['label' => __('Website Tracking'), 'route' => 'dashboard', 'match' => '', 'icon' => 'chart-bar', 'visible' => true],
                ['label' => __('User Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'user-group', 'visible' => true],
            ]
        ],
        [
            'type'  => 'group',
            'label' =>  __('System Settings'),
            'icon'  =>  'server-stack',
            'flyout'   => 'system-settings',
            'active'    => request()->routeIs([]),
            'visible'   => true,
            'items'     => [
                ['label' => __('Sitemap Setting'), 'route' => 'dashboard', 'match' => '', 'icon' => 'globe-alt', 'visible' => true],
                ['label' => __('Htaccess'), 'route' => 'dashboard', 'match' => '', 'icon' => 'code-bracket', 'visible' => true],
                ['label' => __('Backups'), 'route' => 'dashboard', 'match' => '', 'icon' => 'circle-stack', 'visible' => true],
                ['label' => __('Cache Management'), 'route' => 'dashboard', 'match' => '', 'icon' => 'trash', 'visible' => true],
                ['label' => __('System Information'), 'route' => 'dashboard', 'match' => '', 'icon' => 'information-circle', 'visible' => true],
                ['label' => __('Activity Logs'), 'route' => 'dashboard', 'match' => '', 'icon' => 'clipboard-document-list', 'visible' => true],
            ]
        ]
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        settingsOpen: false,
        helpOpen: false,
        mode: localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system',
        applyAppearance(selected) {
            this.mode = selected;

            if (this.$flux) {
                this.$flux.appearance = selected;
            }

            if (selected === 'dark') {
                localStorage.setItem('theme', 'dark');
                localStorage.setItem('flux.appearance', 'dark');
                document.documentElement.classList.add('dark');
            } else if (selected === 'light') {
                localStorage.setItem('theme', 'light');
                localStorage.setItem('flux.appearance', 'light');
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.removeItem('theme');
                localStorage.setItem('flux.appearance', 'system');
                document.documentElement.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches);
            }

            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: selected } }));
        }
    }"
    x-on:keydown.escape.window="settingsOpen = false; helpOpen = false"
    class="min-h-screen bg-white dark:bg-zinc-800"
>

<flux:header sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item icon="inbox" badge="12" href="#">{{ __('Inbox') }}</flux:navbar.item>
        <flux:separator vertical variant="subtle" class="my-2"/>
        <flux:dropdown class="max-lg:hidden">
            <flux:navbar.item icon:trailing="chevron-down">{{__('Favorites')}}</flux:navbar.item>
            <flux:navmenu>
                <flux:navmenu.item href="#">{{__('Marketing site')}}</flux:navmenu.item>
                <flux:navmenu.item href="#">{{__('Android app')}}</flux:navmenu.item>
                <flux:navmenu.item href="#">{{ __('Brand guidelines') }}</flux:navmenu.item>
            </flux:navmenu>
        </flux:dropdown>
    </flux:navbar>
    <flux:spacer />
    <flux:navbar class="me-4">
        <flux:navbar.item icon="magnifying-glass" href="#" label="Search" />
        <flux:navbar.item icon="globe-alt" :href="route('home')" target="_blank" label="{{ __('Visit Website') }}" />
        <flux:button type="button" variant="ghost" icon="cog-6-tooth" class="max-lg:hidden" x-on:click="settingsOpen = true" aria-label="{{ __('Open settings') }}" />
    </flux:navbar>

    <flux:dropdown align="end">
        <flux:profile
            :initials="auth()->user()->initials()"
            :avatar="filled(auth()->user()->picture) ? asset('storage/' . auth()->user()->picture) : null"
        />

        <flux:menu class="min-w-72">
            <div class="px-3 py-3">
                <div class="flex items-start gap-3">
                    <div class="min-w-0 flex-1">
                        <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                        <flux:text size="sm" class="truncate">{{ auth()->user()->email }}</flux:text>
                        <div class="mt-2 flex flex-wrap gap-1.5"></div>
                    </div>
                </div>
            </div>

            <flux:menu.separator />

            <flux:menu.item :href="route('profile.edit')" icon="user" wire:navigate>
                {{ __('Profile Settings') }}
            </flux:menu.item>
            <flux:menu.item :href="route('security.edit')" icon="shield-check" wire:navigate>
                {{ __('Security') }}
            </flux:menu.item>
            <flux:menu.item :href="route('appearance.edit')" icon="paint-brush" wire:navigate>
                {{ __('Appearance') }}
            </flux:menu.item>
            <flux:menu.item icon="cog-6-tooth" x-on:click="settingsOpen = true">
                {{ __('Quick Settings') }}
            </flux:menu.item>

            <flux:menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30"
                    data-test="logout-button"
                >
                    <flux:icon.arrow-right-start-on-rectangle class="size-4" />
                    <span>{{ __('Log out') }}</span>
                </button>
            </form>
        </flux:menu>
    </flux:dropdown>
</flux:header>

<flux:sidebar sticky collapsible class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <flux:sidebar.header>
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
        <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        <!-- Dynamic Menu Loop -->
        @foreach($menuItems as $item)
            @if($item['visible'])

                @if($item['type'] === 'link')
                    @if($item['icon'] === 'custom-omr-frame')
                        <flux:sidebar.item :href="route($item['route'])" :current="request()->routeIs($item['match'])" wire:navigate>
                            <x-slot:icon>
                                <x-omr-icon class="size-5 text-zinc-500 group-hover:text-emerald-600" />
                            </x-slot:icon>
                            {{ $item['label'] }}
                        </flux:sidebar.item>
                    @else
                        <flux:sidebar.item :icon="$item['icon']" :href="route($item['route'])" :current="request()->routeIs($item['match'])" wire:navigate>
                            {{ $item['label'] }}
                        </flux:sidebar.item>
                    @endif

                @elseif($item['type'] === 'group')
                    <flux:sidebar.group expandable :icon="$item['icon']" :heading="$item['label']" :expanded="$item['active']" class="grid">
                        @foreach($item['items'] as $subItem)
                            @if($subItem['visible'])
                                <flux:sidebar.item
                                    :icon="$subItem['icon'] ?? null"
                                    :href="route($subItem['route'])"
                                    :current="filled($subItem['match']) ? request()->routeIs($subItem['match']) : false"
                                    wire:navigate
                                >
                                    {{ $subItem['label'] }}
                                </flux:sidebar.item>
                            @endif
                        @endforeach
                    </flux:sidebar.group>
                @endif

            @endif
        @endforeach
    </flux:sidebar.nav>

    <flux:spacer />

    <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
</flux:sidebar>

<!-- Mobile User Menu -->
<flux:header class="hidden">
    <flux:sidebar.toggle class="hidden" icon="bars-2" inset="left" />

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

@persist('toast')
<flux:toast />
@endpersist

<x-delete-confirmation />

@fluxScripts
@stack('scripts')
</body>
</html>

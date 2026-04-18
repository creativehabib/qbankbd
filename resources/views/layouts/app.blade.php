@php
    $pageTitle = $pageTitle ?? $title ?? 'Dashboard';
@endphp

<x-layouts::app.sidebar :title="$title ?? null">
    <!-- স্টিকি হেডার (সব পেজে থাকবে) -->
    <div class="sticky top-0 z-30 border-b border-zinc-200 bg-white/95 backdrop-blur dark:border-zinc-700 dark:bg-zinc-900/95">
        <div class="px-6 py-2">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <!-- বাম: পেজ টাইটেল -->
                <div>
                    <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $pageTitle }}</h1>
                    @isset($pageSubtitle)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $pageSubtitle }}</p>
                    @endisset
                </div>

                <!-- ডান: থিম + প্রোফাইল -->
                <div class="flex items-center gap-2">
                    <!-- থিম সিলেক্টর -->
                    <flux:dropdown position="bottom" align="end">
                        <flux:button variant="ghost" icon="moon" size="sm">
                            {{ __('Theme') }}
                        </flux:button>

                        <flux:menu>
                            <flux:menu.radio.group x-model="$flux.appearance">
                                <flux:menu.item value="light" icon="sun">{{ __('Light') }}</flux:menu.item>
                                <flux:menu.item value="dark" icon="moon">{{ __('Dark') }}</flux:menu.item>
                                <flux:menu.item value="system" icon="computer-desktop">{{ __('System') }}</flux:menu.item>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <!-- প্রোফাইল ড্রপডাউন -->
                    <flux:dropdown position="bottom" align="end">
                        <flux:profile
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                            icon-trailing="chevron-down"
                        />

                        <flux:menu>
                            <!-- প্রোফাইল তথ্য -->
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

                            <flux:menu.separator />

                            <!-- সেটিংস -->
                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                                    {{ __('Settings') }}
                                </flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <!-- লগআউট -->
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item
                                    as="button"
                                    type="submit"
                                    icon="arrow-right-start-on-rectangle"
                                    class="w-full cursor-pointer"
                                >
                                    {{ __('Log out') }}
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </div>
            </div>
        </div>
    </div>

    <!-- মূল কন্টেন্ট -->
    <flux:main class="pt-5">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>

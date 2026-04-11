<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Appearance settings')] class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Appearance settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <div
            x-data="darkThemeCustomizer()"
            x-init="init()"
            class="space-y-6"
        >
            <flux:radio.group variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
            </flux:radio.group>

            <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                <flux:heading size="sm">{{ __('Dark Mode Colors') }}</flux:heading>
                <flux:text class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                    {{ __('Set your preferred dark mode palette. Changes are saved in this browser.') }}
                </flux:text>

                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Background') }}</span>
                        <input type="color" x-model="theme.darkBg" @input="applyTheme()" class="h-10 w-full cursor-pointer rounded-md border border-zinc-200 dark:border-zinc-700" />
                    </label>
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Panel') }}</span>
                        <input type="color" x-model="theme.darkPanel" @input="applyTheme()" class="h-10 w-full cursor-pointer rounded-md border border-zinc-200 dark:border-zinc-700" />
                    </label>
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Border') }}</span>
                        <input type="color" x-model="theme.darkBorder" @input="applyTheme()" class="h-10 w-full cursor-pointer rounded-md border border-zinc-200 dark:border-zinc-700" />
                    </label>
                    <label class="space-y-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Active Item') }}</span>
                        <input type="color" x-model="theme.darkActiveBg" @input="applyTheme()" class="h-10 w-full cursor-pointer rounded-md border border-zinc-200 dark:border-zinc-700" />
                    </label>
                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ __('Active Text') }}</span>
                        <input type="color" x-model="theme.darkActiveText" @input="applyTheme()" class="h-10 w-full cursor-pointer rounded-md border border-zinc-200 dark:border-zinc-700" />
                    </label>
                </div>

                <div class="mt-4">
                    <flux:button type="button" variant="ghost" icon="arrow-path" @click="resetTheme()">
                        {{ __('Reset dark mode colors') }}
                    </flux:button>
                </div>
            </div>
        </div>
    </x-pages::settings.layout>
</section>

@script
<script>
    function darkThemeCustomizer() {
        return {
            storageKey: 'custom-dark-theme',
            defaults: {
                darkBg: '#020a1f',
                darkPanel: '#0b1428',
                darkBorder: '#06b6d4',
                darkActiveBg: '#0e7490',
                darkActiveText: '#cffafe',
            },
            theme: {
                darkBg: '#020a1f',
                darkPanel: '#0b1428',
                darkBorder: '#06b6d4',
                darkActiveBg: '#0e7490',
                darkActiveText: '#cffafe',
            },
            init() {
                const savedTheme = localStorage.getItem(this.storageKey);

                if (savedTheme) {
                    this.theme = { ...this.defaults, ...JSON.parse(savedTheme) };
                }

                this.applyTheme();
            },
            applyTheme() {
                const root = document.documentElement;

                root.style.setProperty('--app-dark-bg', this.theme.darkBg);
                root.style.setProperty('--app-dark-panel', this.theme.darkPanel);
                root.style.setProperty('--app-dark-border', `${this.theme.darkBorder}33`);
                root.style.setProperty('--app-dark-active-bg', `${this.theme.darkActiveBg}40`);
                root.style.setProperty('--app-dark-active-text', this.theme.darkActiveText);

                localStorage.setItem(this.storageKey, JSON.stringify(this.theme));
            },
            resetTheme() {
                this.theme = { ...this.defaults };
                this.applyTheme();
            },
        };
    }
</script>
@endscript

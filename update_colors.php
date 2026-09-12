<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

// Accent color section replacement
$searchAccent = '/<label class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Suggested<\/label>.*?<\/flux:card>/s';

$replaceAccent = <<<'BLADE'
                        <label class="text-[11px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">Suggested</label>
                        <div class="flex flex-wrap gap-2">
                            @php
                                $colors = [
                                    '#f97316', // Orange
                                    '#f43f5e', // Rose/Pink
                                    '#9f1239', // Dark Red
                                    '#8b5cf6', // Purple
                                    '#3b82f6', // Blue
                                    '#06b6d4', // Cyan
                                    '#10b981', // Emerald
                                    '#d97706', // Yellow/Amber
                                    '#0f172a', // Slate/Black
                                ];
                            @endphp
                            @foreach($colors as $color)
                                <button type="button" wire:click="$set('accent_color', '{{ $color }}')" 
                                        class="w-8 h-8 rounded-lg shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                        {{ $accent_color === $color ? 'ring-2 ring-accent ring-offset-2 dark:ring-offset-zinc-900' : 'border border-zinc-200 dark:border-zinc-700' }}"
                                        style="background-color: {{ $color }};">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="text-[11px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider">Custom</label>
                        <div class="flex items-center">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <div class="relative flex items-center justify-center size-10 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1 shadow-sm">
                                    <div class="w-full h-full rounded-[4px]" style="background-color: {{ $accent_color }};"></div>
                                    <input type="color" wire:model.live="accent_color" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />
                                </div>
                                <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 w-16">{{ strtoupper($accent_color) }}</span>
                            </label>
                            <button type="button" wire:click="$set('accent_color', '#f97316')" class="text-sm font-medium text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors ml-4">
                                Reset to default
                            </button>
                        </div>
                    </div>
                </div>
            </flux:card>
BLADE;

$content = preg_replace($searchAccent, $replaceAccent, $content);

// Text color section replacement
$searchText = '/<flux:card>\s*<div class="mb-4">\s*<h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Text color<\/h3>.*?<\/flux:card>/s';

$replaceText = <<<'BLADE'
            <flux:card>
                <div class="mb-4">
                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Text color</h3>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">The color of text and icons sitting on accent-filled buttons. Pick the one with the best contrast.</p>
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex gap-2">
                        <button type="button" wire:click="$set('text_color', '#ffffff')" 
                                class="w-8 h-8 rounded-lg shadow-sm transition-all bg-white border border-zinc-200 dark:border-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                {{ $text_color === '#ffffff' ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-2 dark:ring-offset-zinc-900' : '' }}">
                        </button>
                        <button type="button" wire:click="$set('text_color', '#000000')" 
                                class="w-8 h-8 rounded-lg shadow-sm transition-all bg-black border border-zinc-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-900 dark:focus:ring-offset-zinc-900
                                {{ $text_color === '#000000' ? 'ring-2 ring-zinc-900 dark:ring-white ring-offset-2 dark:ring-offset-zinc-900' : '' }}">
                        </button>
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer ml-2">
                        <div class="relative flex items-center justify-center size-10 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg p-1 shadow-sm">
                            <div class="w-full h-full rounded-[4px] border border-black/10 dark:border-white/10" style="background-color: {{ $text_color }};"></div>
                            <input type="color" wire:model.live="text_color" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full" />
                        </div>
                        <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300 w-16">{{ strtoupper($text_color) }}</span>
                    </label>
                </div>
            </flux:card>
BLADE;

$content = preg_replace($searchText, $replaceText, $content);

file_put_contents($file, $content);

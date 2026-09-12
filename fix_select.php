<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
                    <flux:select wire:model="default_theme" class="w-full">
                        <option value="System">System default</option>
                        <option value="Light">Light</option>
                        <option value="Dark">Dark</option>
                    </flux:select>
BLADE;

$replace = <<<'BLADE'
                    <flux:select wire:model="default_theme" class="w-full">
                        <flux:select.option value="System">System default</flux:select.option>
                        <flux:select.option value="Light">Light</flux:select.option>
                        <flux:select.option value="Dark">Dark</flux:select.option>
                    </flux:select>
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

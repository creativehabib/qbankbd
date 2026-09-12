<?php

$file = 'resources/views/components/modern-list-header.blade.php';
$content = file_get_contents($file);

$sortButton = '<flux:button variant="ghost" size="sm" icon="arrows-up-down" class="text-zinc-500">Sort</flux:button>';

$dropdown = <<<'BLADE'
        <flux:dropdown>
            <flux:button variant="ghost" size="sm" icon="arrows-up-down" icon-trailing="chevron-down" class="text-zinc-500">Sort</flux:button>
            <flux:menu class="w-48">
                <flux:menu.radio.group wire:model.live="sortField">
                    <flux:menu.radio value="default">Default order</flux:menu.radio>
                    <flux:menu.separator />
                    <flux:menu.radio value="name_asc">Name A &rarr; Z</flux:menu.radio>
                    <flux:menu.radio value="name_desc">Name Z &rarr; A</flux:menu.radio>
                </flux:menu.radio.group>
            </flux:menu>
        </flux:dropdown>
BLADE;

$content = str_replace($sortButton, $dropdown, $content);
file_put_contents($file, $content);

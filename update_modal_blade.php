<?php

$file = 'resources/views/components/modern-toggle-modal.blade.php';
$content = file_get_contents($file);

$content = str_replace('<flux:modal name="{{ $name }}" class="md:w-96">', '<flux:modal wire:model="showToggleModal" class="md:w-96">', $content);

file_put_contents($file, $content);

<?php

$files = [
    'resources/views/components/modern-page-header.blade.php',
];

foreach ($files as $file) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // The button is in modern-page-header.blade.php
    // Before: wire:click="$set('isCreating', true); cancelEdit()" OR x-on:click="$dispatch('start-creating')"
    $content = str_replace('x-on:click="$dispatch(\'start-creating\')"', 'wire:click="create"', $content);
    $content = preg_replace('/wire:click="\$set\([^\)]+\);\s*[a-zA-Z]+\(\)"/', 'wire:click="create"', $content);

    file_put_contents($file, $content);
    echo "Fixed create button in $file\n";
}

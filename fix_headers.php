<?php

$files = glob('resources/views/livewire/*/*.blade.php');
$files = array_merge($files, glob('resources/views/livewire/*/*/*.blade.php'));

foreach ($files as $file) {
    if (! str_contains(file_get_contents($file), 'x-modern-page-header')) {
        continue;
    }

    $content = file_get_contents($file);

    // Extract the modern-page-header tag
    preg_match('/<x-modern-page-header[^>]*>.*?<\/x-modern-page-header>/s', $content, $matches);
    if (empty($matches)) {
        preg_match('/<x-modern-page-header[^>]*><\/x-modern-page-header>/s', $content, $matches);
    }

    if (! empty($matches)) {
        $headerHtml = $matches[0];

        // Remove it from its current position
        $content = str_replace($headerHtml, '', $content);

        // Insert it at the top, inside x-slot:header
        $headerSlot = "\n    <x-slot:header>\n        ".$headerHtml."\n    </x-slot:header>\n";

        $content = preg_replace('/<x-split-layout>/', '<x-split-layout>'.$headerSlot, $content);

        file_put_contents($file, $content);
        echo "Fixed header in $file\n";
    }
}

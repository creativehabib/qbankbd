<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php',
    'resources/views/livewire/chapters/chapter-index.blade.php',
    'resources/views/livewire/academic-classes/class-index.blade.php',
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php',
    'resources/views/livewire/admin/tags/index.blade.php',
    'resources/views/livewire/subjects/subject-index.blade.php',
];

foreach ($files as $file) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    if (! str_contains($content, '<x-modern-toggle-modal />')) {
        // Append before closing tag of x-split-layout or just at the end
        if (str_contains($content, '</x-split-layout>')) {
            $content = str_replace('</x-split-layout>', "    <x-modern-toggle-modal />\n</x-split-layout>", $content);
        } else {
            $content .= "\n<x-modern-toggle-modal />\n";
        }
        file_put_contents($file, $content);
        echo "Added modal to $file\n";
    }
}

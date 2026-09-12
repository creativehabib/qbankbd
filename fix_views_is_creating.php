<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => 'editId',
    'resources/views/livewire/chapters/chapter-index.blade.php' => 'editId',
    'resources/views/livewire/academic-classes/class-index.blade.php' => 'editingClassId',
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => 'editId',
    'resources/views/livewire/admin/tags/index.blade.php' => 'editingId',
    'resources/views/livewire/subjects/subject-index.blade.php' => 'editId',
];

foreach ($files as $file => $var) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Replace x-data wrapper with simple div
    $content = preg_replace('/<div x-data="\{ isCreating: false \}"[^>]+>/', '<div>', $content);

    // Replace x-show for empty state
    $content = preg_replace('/<div x-show="!isCreating && !\{\{ \$'.$var.' \? \'true\' : \'false\' \}\}">(.*?)<\/div>\s*<form/s', '@if(!$isCreating && !$'.$var.")\n            <div>$1</div>\n        @else\n            <form", $content);

    // Replace x-show in form
    $content = preg_replace('/<form wire:submit="save" class="space-y-4" x-show="isCreating \|\| \{\{ \$'.$var.' \? \'true\' : \'false\' \}\}" x-cloak>/', '<form wire:submit="save" class="space-y-4">', $content);

    // Add @endif before closing form div
    $content = preg_replace('/<\/form>\s*<\/div>\s*<\/x-slot:form>/', "</form>\n        @endif\n        </div>\n    </x-slot:form>", $content);

    // Fix start-creating button
    $content = str_replace('x-on:click="$dispatch(\'start-creating\')"', 'wire:click="$set(\'isCreating\', true); cancelEdit()"', $content);

    // Fix cancel buttons inside form
    $content = preg_replace('/x-on:click="isCreating = false; \$wire\.[^"]+"/', 'wire:click="cancelEdit"', $content);
    $content = preg_replace('/x-on:click="isCreating = false; \$wire.cancelEdit \? \$wire.cancelEdit\(\) : \$wire.resetClassForm\(\)"/', 'wire:click="cancelEdit"', $content);

    // Wait, ClassIndex uses resetClassForm!
    if ($file === 'resources/views/livewire/academic-classes/class-index.blade.php') {
        $content = str_replace('wire:click="cancelEdit"', 'wire:click="resetClassForm"', $content);
        $content = str_replace('wire:click="$set(\'isCreating\', true); cancelEdit()"', 'wire:click="$set(\'isCreating\', true); resetClassForm()"', $content);
    }

    file_put_contents($file, $content);
    echo "Fixed view $file\n";
}

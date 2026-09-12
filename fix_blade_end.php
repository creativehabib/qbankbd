<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => ['var' => 'topic'],
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['var' => 'chapter'],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['var' => 'class'],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['var' => 'examCat'],
    'resources/views/livewire/subjects/subject-index.blade.php' => ['var' => 'subject'],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);
    $var = $config['var'];

    // The existing slot is like:
    /*
        <x-slot:end>
            {{ $topic->is_premium ? 'Premium' : 'Standard' }}
        </x-slot:end>
    */

    // We want to replace it with:
    $newSlot = <<<BLADE
        <x-slot:end>
            <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md" title="Questions Count">
                <flux:icon icon="document-text" class="size-3.5" />
                {{ \$${var}->questions_count ?? 0 }}
            </div>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ \$${var}->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
BLADE;

    // Use regex to replace the slot
    $content = preg_replace('/<x-slot:end>\s*\{\{\s*\$'.$var.'->is_premium\s*\?\s*\'Premium\'\s*:\s*\'Standard\'\s*\}\}\s*<\/x-slot:end>/s', $newSlot, $content);

    file_put_contents($file, $content);
    echo "Fixed end slot in $file\n";
}

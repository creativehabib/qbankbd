<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => ['var' => 'topic', 'sub' => '{{ $topic->subject->name ?? \'No Subject\' }} {{ $topic->chapter ? \' • \'.$topic->chapter->name : \'\' }}'],
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['var' => 'chapter', 'sub' => '{{ $chapter->subject?->name ?? \'N/A\' }}{{ $chapter->subject?->academicClass?->name ? \' (\'.$chapter->subject->academicClass->name.\')\' : \'\' }}'],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['var' => 'class', 'sub' => ''],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['var' => 'examCat', 'sub' => ''],
    'resources/views/livewire/subjects/subject-index.blade.php' => ['var' => 'subject', 'sub' => '{{ $subject->academicClass?->name ?? \'N/A\' }} {{ $subject->subject_code ? \' • \'.$subject->subject_code : \'\' }}'],
    'resources/views/livewire/admin/tags/index.blade.php' => ['var' => 'tag', 'sub' => ''],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);
    $var = $config['var'];
    $sub = $config['sub'];

    // First, remove the question count from x-slot:end
    // The previous format was:
    /*
        <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md" title="Questions Count">
            <flux:icon icon="document-text" class="size-3.5" />
            {{ $var->questions_count ?? 0 }}
        </div>
    */
    // We will just remove any div containing 'Questions Count'
    $content = preg_replace('/<div[^>]*title="Questions Count"[^>]*>.*?<\/div>\s*/s', '', $content);

    // For Tags, we might have added an empty <x-slot:end> after removal.
    $content = preg_replace('/<x-slot:end>\s*<\/x-slot:end>/s', '', $content);

    // Now update subtitle.
    // If it already has subtitle="...", replace it.
    $newSub = trim($sub) ? $sub.' • {{ $'.$var.'->questions_count ?? 0 }} Questions' : '{{ $'.$var.'->questions_count ?? 0 }} Questions';

    if (preg_match('/subtitle="([^"]*)"/', $content)) {
        $content = preg_replace('/subtitle="([^"]*)"/', 'subtitle="'.$newSub.'"', $content);
    } else {
        // Find title="..." and add subtitle="..." after it
        $content = preg_replace('/title="([^"]*)"/', 'title="$1"'."\n                    subtitle=\"".$newSub.'"', $content);
    }

    file_put_contents($file, $content);
    echo "Fixed subtitle in $file\n";
}

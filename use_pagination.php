<?php

$files = [
    'resources/views/livewire/chapters/chapter-index.blade.php' => 'chapters',
    'resources/views/livewire/academic-classes/class-index.blade.php' => 'academicClasses',
    'resources/views/livewire/subjects/subject-index.blade.php' => 'subjects',
    'resources/views/livewire/topics/topic-index.blade.php' => 'topics',
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => 'examCategories',
    'resources/views/livewire/admin/tags/index.blade.php' => 'tags',
];

foreach ($files as $file => $var) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Replace:
    // @if($subjects->hasPages())
    //      <div class="p-4 bg-zinc-50/50 dark:bg-zinc-800/20">
    //          {{ $subjects->links() }}
    //      </div>
    // @endif
    // With just {{ $subjects->links('components.modern-pagination') }}

    $content = preg_replace('/@if\(\$'.$var.'->hasPages\(\)\).*?<\/div>\s*@endif/s', '{{ $'.$var.'->links(\'components.modern-pagination\') }}', $content);

    // Some tags might not have @if
    $content = preg_replace('/<div class="p-4 bg-zinc-50\/50 dark:bg-zinc-800\/20">\s*\{\{ \$'.$var.'->links\(\) \}\}\s*<\/div>/s', '{{ $'.$var.'->links(\'components.modern-pagination\') }}', $content);

    file_put_contents($file, $content);
    echo "Updated pagination view in $file\n";
}

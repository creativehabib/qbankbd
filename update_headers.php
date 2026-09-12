<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => ['title' => 'Topics', 'desc' => 'Manage topics under subjects and chapters.', 'model' => 'topic'],
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['title' => 'Chapters', 'desc' => 'Manage chapters assigned to subjects.', 'model' => 'chapter'],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['title' => 'Academic Class', 'desc' => 'Create, search and manage classes from one place.', 'model' => 'class'],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['title' => 'Exam Categories', 'desc' => 'Manage exam categories like Admission Exam, Board Exam etc.', 'model' => 'category'],
    'resources/views/livewire/admin/tags/index.blade.php' => ['title' => 'Tags', 'desc' => 'Manage tags for subjects and questions.', 'model' => 'tag'],
    'resources/views/livewire/subjects/subject-index.blade.php' => ['title' => 'Subjects', 'desc' => 'Manage subjects assigned to classes.', 'model' => 'subject'],
];

foreach ($files as $file => $config) {
    $content = file_get_contents($file);

    // Find <div class="border-b border-gray-100...
    $pattern = '/<div class="border-b border-gray-100[^>]*>.*?<\/div>\s*<\/div>\s*<\/div>/s';

    // Check if topics has the select dropdown
    $actionsHtml = '';
    if (strpos($file, 'topic-index') !== false) {
        $pattern = '/<div class="border-b border-gray-100[^>]*>.*?<\/flux:button>\s*<\/div>\s*<\/div>\s*<\/div>/s';
        $actionsHtml = "\n            <x-slot:actions>\n                <flux:select wire:model.live=\"subjectId\" class=\"w-full sm:w-48\">\n                    <flux:select.option value=\"\">All Subjects</flux:select.option>\n                    @foreach(\$subjects as \$sub)\n                        <flux:select.option value=\"{{ \$sub->id }}\">{{ \$sub->name }}</flux:select.option>\n                    @endforeach\n                </flux:select>\n            </x-slot:actions>";
    }

    $replacement = '<x-modern-page-header title="'.$config['title'].'" description="'.$config['desc'].'" modelName="'.$config['model'].'">'.$actionsHtml.'</x-modern-page-header>';

    $newContent = preg_replace($pattern, $replacement, $content, 1);

    if ($newContent !== null) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}

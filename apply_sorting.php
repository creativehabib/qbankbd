<?php

$files = [
    'app/Livewire/Topics/TopicIndex.php' => 'search',
    'app/Livewire/Chapters/ChapterIndex.php' => 'search',
    'app/Livewire/AcademicClasses/ClassIndex.php' => 'classSearch',
    'app/Livewire/ExamCategories/ExamCategoriesIndex.php' => 'search',
    'app/Livewire/Tags/Index.php' => 'search',
    'app/Livewire/Subjects/SubjectIndex.php' => 'search',
];

foreach ($files as $file => $searchVar) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Replace ->orderBy('name') or ->latest() or missing sort with match()
    $sortLogic = <<<'PHP'
->when($this->sortField === 'name_asc', fn ($q) => $q->orderBy('name', 'asc'))
            ->when($this->sortField === 'name_desc', fn ($q) => $q->orderBy('name', 'desc'))
            ->when($this->sortField === 'default', fn ($q) => $q->latest())
PHP;

    if (str_contains($content, '->orderBy(\'name\')')) {
        $content = str_replace("->orderBy('name')", $sortLogic, $content);
    } elseif (str_contains($content, '->latest()')) {
        // Only replace the first ->latest() which is for the main query
        $content = preg_replace('/->latest\(\)/', $sortLogic, $content, 1);
    } else {
        // TagIndex might not have orderBy
        $content = preg_replace('/->paginate\(\$this->perPage\)/', $sortLogic."\n            ->paginate(\$this->perPage)", $content, 1);
    }

    file_put_contents($file, $content);
    echo "Applied sorting to $file\n";
}

<?php

$files = [
    'app/Livewire/Topics/TopicIndex.php',
    'app/Livewire/Chapters/ChapterIndex.php',
    'app/Livewire/AcademicClasses/ClassIndex.php',
    'app/Livewire/ExamCategories/ExamCategoriesIndex.php',
    'app/Livewire/Tags/Index.php',
    'app/Livewire/Subjects/SubjectIndex.php',
];

foreach ($files as $file) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    if (! str_contains($content, 'public $sortField')) {
        // Find public $perPage = 10;
        $content = preg_replace('/(public \$perPage\s*=\s*\d+;)/', "$1\n    public \$sortField = 'default';", $content);
        file_put_contents($file, $content);
        echo "Added sortField to $file\n";
    }
}

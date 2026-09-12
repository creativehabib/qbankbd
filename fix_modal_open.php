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

    // Add public $showToggleModal = false;
    if (! str_contains($content, 'showToggleModal')) {
        $content = preg_replace('/public \$toggleTargetState = false;/', "public \$toggleTargetState = false;\n    public \$showToggleModal = false;", $content);
    }

    // Replace \Flux::modal('toggle-confirm')->show();
    $content = str_replace("\Flux::modal('toggle-confirm')->show();", '$this->showToggleModal = true;', $content);

    // Replace \Flux::modal('toggle-confirm')->close();
    $content = str_replace("\Flux::modal('toggle-confirm')->close();", '$this->showToggleModal = false;', $content);

    file_put_contents($file, $content);
    echo "Fixed modal opening in $file\n";
}

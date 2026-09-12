<?php

$files = [
    'app/Livewire/Topics/TopicIndex.php',
    'app/Livewire/Chapters/ChapterIndex.php',
    'app/Livewire/AcademicClasses/ClassIndex.php',
    'app/Livewire/ExamCategories/ExamCategoriesIndex.php',
    'app/Livewire/Admin/Tags/Index.php',
    'app/Livewire/Subjects/SubjectIndex.php',
];

foreach ($files as $file) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    if (! str_contains($content, '$isCreating')) {
        $content = preg_replace('/class [a-zA-Z0-9_]+ extends Component\s*\{/', "$0\n    public \$isCreating = false;\n", $content);
    }

    // In edit() methods, we should set $isCreating = false
    // We'll just replace 'public function edit(' with 'public function edit(' and add $this->isCreating = false; inside
    $content = preg_replace('/public function edit\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);
    $content = preg_replace('/public function editClass\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);

    // In cancelEdit, set $isCreating = false
    $content = preg_replace('/public function cancelEdit\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);
    $content = preg_replace('/public function resetClassForm\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);

    file_put_contents($file, $content);
    echo "Added isCreating to $file\n";
}

<?php

$files = [
    'app/Livewire/Topics/TopicIndex.php' => 'cancelEdit',
    'app/Livewire/Chapters/ChapterIndex.php' => 'cancelEdit',
    'app/Livewire/AcademicClasses/ClassIndex.php' => 'resetClassForm',
    'app/Livewire/ExamCategories/ExamCategoriesIndex.php' => 'cancelEdit',
    'app/Livewire/Tags/Index.php' => 'cancelEdit',
    'app/Livewire/Subjects/SubjectIndex.php' => 'cancelEdit',
];

foreach ($files as $file => $cancelMethod) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Add create() method
    if (! str_contains($content, 'public function create(')) {
        $createMethod = "
    public function create()
    {
        \$this->$cancelMethod();
        \$this->isCreating = true;
    }
";
        $content = preg_replace('/public function render\(\)/', $createMethod."\n    public function render()", $content);
        file_put_contents($file, $content);
        echo "Added create() to $file\n";
    }
}

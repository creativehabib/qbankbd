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

    // Replace reset array to include isCreating
    $content = preg_replace('/\$this->reset\(\[\'/', '$this->reset([\'isCreating\', \'', $content);

    // For ClassIndex, saveClass, saveSubject, saveChapter, saveTopic
    // They call resetClassForm, resetSubjectForm, etc.
    // I already added $this->isCreating = false to those reset methods!

    // For TagsIndex, save() manually resets:
    $content = str_replace("\$this->editingId = null;\n            \$this->name = '';", "\$this->isCreating = false;\n            \$this->editingId = null;\n            \$this->name = '';", $content);
    $content = str_replace("\$this->name = '';\n            \$this->resetPage();", "\$this->isCreating = false;\n            \$this->name = '';\n            \$this->resetPage();", $content);

    file_put_contents($file, $content);
    echo "Fixed save in $file\n";
}

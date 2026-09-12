<?php

$files = [
    'app/Livewire/Subjects/SubjectIndex.php' => ['model' => 'Subject', 'field' => 'is_active'],
    'app/Livewire/Chapters/ChapterIndex.php' => ['model' => 'Chapter', 'field' => 'is_active'],
    'app/Livewire/AcademicClasses/ClassIndex.php' => ['model' => 'AcademicClass', 'field' => 'class_is_active'],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }

    $content = file_get_contents($file);
    if (str_contains($content, 'toggleActive(')) {
        continue;
    } // Already added

    $method = "
    public function toggleActive(\$id)
    {
        \$item = {$config['model']}::findOrFail(\$id);
        \$item->{$config['field']} = !\$item->{$config['field']};
        \$item->save();
        \$this->toastSuccess('Status updated successfully.');
    }
";

    // Insert before the render method
    $content = preg_replace('/public function render\(\)/', $method."\n    public function render()", $content);
    file_put_contents($file, $content);
    echo "Added toggleActive to $file\n";
}

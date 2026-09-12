<?php

$files = [
    'app/Livewire/Topics/TopicIndex.php' => ['model' => 'Topic', 'field' => 'is_active'],
    'app/Livewire/Chapters/ChapterIndex.php' => ['model' => 'Chapter', 'field' => 'is_active'],
    'app/Livewire/AcademicClasses/ClassIndex.php' => ['model' => 'AcademicClass', 'field' => 'is_active'],
    'app/Livewire/ExamCategories/ExamCategoriesIndex.php' => ['model' => 'ExamCategory', 'field' => 'is_active'],
    'app/Livewire/Tags/Index.php' => ['model' => 'Tag', 'field' => 'is_active'],
    'app/Livewire/Subjects/SubjectIndex.php' => ['model' => 'Subject', 'field' => 'is_active'],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Add properties
    if (! str_contains($content, 'toggleTargetId')) {
        $props = "
    public \$toggleTargetId = null;
    public \$toggleTargetName = '';
    public \$toggleTargetState = false;
";
        $content = preg_replace('/class [a-zA-Z0-9_]+ extends Component\s*\{/', "$0$props", $content);
    }

    // Replace toggleActive method
    $newToggleActive = "
    public function toggleActive(\$id)
    {
        \$item = {$config['model']}::findOrFail(\$id);
        \$this->toggleTargetId = \$id;
        \$this->toggleTargetName = \$item->name;
        \$this->toggleTargetState = !\$item->{$config['field']};
        
        // Open modal via Flux
        \Flux::modal('toggle-confirm')->show();
    }

    public function performToggle()
    {
        if (!\$this->toggleTargetId) return;
        
        \$item = {$config['model']}::findOrFail(\$this->toggleTargetId);
        \$item->{$config['field']} = \$this->toggleTargetState;
        \$item->save();
        
        \$this->toastSuccess('Status updated successfully.');
        \Flux::modal('toggle-confirm')->close();
        \$this->toggleTargetId = null;
    }
";

    // If toggleActive exists, replace it
    if (str_contains($content, 'public function toggleActive')) {
        $content = preg_replace('/public function toggleActive\(\$id\)\s*\{[^\}]+\$item->save\(\);[^\}]+\}/s', trim($newToggleActive), $content);
    } else {
        // Just insert it before render
        $content = preg_replace('/public function render\(\)/', trim($newToggleActive)."\n\n    public function render()", $content);
    }

    file_put_contents($file, $content);
    echo "Updated $file\n";
}

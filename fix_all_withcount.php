<?php

function addWithCount($file, $regex, $replacement)
{
    $content = file_get_contents($file);
    if (! str_contains($content, "withCount('questions')")) {
        $content = preg_replace($regex, $replacement, $content, 1);
        file_put_contents($file, $content);
        echo "Fixed $file\n";
    }
}

addWithCount('app/Livewire/Subjects/SubjectIndex.php', '/Subject::with/', "Subject::withCount('questions')->with");
addWithCount('app/Livewire/Chapters/ChapterIndex.php', '/Chapter::with/', "Chapter::withCount('questions')->with");
addWithCount('app/Livewire/ExamCategories/ExamCategoriesIndex.php', '/ExamCategory::when/', "ExamCategory::withCount('questions')->when");
addWithCount('app/Livewire/Tags/Index.php', '/Tag::query\(\)/', "Tag::query()->withCount('questions')");

// Also let's check AcademicClass and Topic just in case.
addWithCount('app/Livewire/AcademicClasses/ClassIndex.php', '/AcademicClass::query\(\)/', "AcademicClass::query()->withCount('questions')");
addWithCount('app/Livewire/Topics/TopicIndex.php', '/Topic::with/', "Topic::withCount('questions')->with");

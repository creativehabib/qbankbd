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

    // Add withCount('questions') to the queries
    if (str_contains($content, 'Topic::with(\'subject\'')) {
        $content = str_replace("Topic::with('subject', 'chapter')", "Topic::with('subject', 'chapter')->withCount('questions')", $content);
    } elseif (str_contains($content, 'Chapter::with(\'subject\')')) {
        $content = str_replace("Chapter::with('subject')", "Chapter::with('subject')->withCount('questions')", $content);
    } elseif (str_contains($content, 'AcademicClass::query()')) {
        $content = str_replace('AcademicClass::query()', "AcademicClass::query()->withCount('questions')", $content);
    } elseif (str_contains($content, 'ExamCategory::query()')) {
        $content = str_replace('ExamCategory::query()', "ExamCategory::query()->withCount('questions')", $content);
    } elseif (str_contains($content, 'Tag::query()')) {
        $content = str_replace('Tag::query()', "Tag::query()->withCount('questions')", $content);
    } elseif (str_contains($content, 'Subject::query()')) {
        // ClassIndex has Subject::query() but we want the main SubjectIndex
        if (str_contains($content, 'class SubjectIndex')) {
            $content = str_replace('Subject::query()', "Subject::query()->withCount('questions')", $content);
        }
    }

    file_put_contents($file, $content);
    echo "Added withCount to $file\n";
}

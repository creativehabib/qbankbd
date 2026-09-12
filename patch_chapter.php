<?php

$file = 'app/Livewire/Chapters/ChapterIndex.php';
$content = file_get_contents($file);

$content = str_replace('Chapter::with(\'subject.academicClass\')', 'Chapter::withCount(\'questions\')->with(\'subject.academicClass\')', $content);

file_put_contents($file, $content);

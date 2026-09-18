<?php
$file = 'resources/views/frontend/header.blade.php';
$content = file_get_contents($file);

$content = preg_replace(
    '/<svg id="theme-toggle-dark-icon" class="[^"]*" fill="currentColor" viewBox="0 0 20 20">/',
    '<svg class="w-5 h-5 block dark:hidden pointer-events-none" fill="currentColor" viewBox="0 0 20 20">',
    $content
);

$content = preg_replace(
    '/<svg id="theme-toggle-light-icon" class="[^"]*" fill="currentColor" viewBox="0 0 20 20">/',
    '<svg class="w-5 h-5 hidden dark:block pointer-events-none" fill="currentColor" viewBox="0 0 20 20">',
    $content
);

file_put_contents($file, $content);
echo "Restored SVG classes in header.blade.php\n";

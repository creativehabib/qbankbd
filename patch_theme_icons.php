<?php
$file = 'resources/views/frontend/header.blade.php';
$content = file_get_contents($file);

// Add id="theme-toggle-dark-icon" to the moon SVG
$content = str_replace(
    '<svg class="w-5 h-5 block dark:hidden pointer-events-none" fill="currentColor"',
    '<svg id="theme-toggle-dark-icon" class="w-5 h-5 block dark:hidden pointer-events-none" fill="currentColor"',
    $content
);

// Add id="theme-toggle-light-icon" to the sun SVG
$content = str_replace(
    '<svg class="w-5 h-5 hidden dark:block pointer-events-none" fill="currentColor"',
    '<svg id="theme-toggle-light-icon" class="w-5 h-5 hidden dark:block pointer-events-none" fill="currentColor"',
    $content
);

file_put_contents($file, $content);
echo "Patched header.blade.php with icon IDs.\n";

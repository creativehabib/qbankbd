<?php

$file = 'resources/views/flux/sidebar/group.blade.php';
$content = file_get_contents($file);

// Add data-current attribute if expanded
$content = str_replace(
    '<button type="button" class="border-1',
    '<button type="button" @if($expanded) data-current @endif class="border-1',
    $content
);

// Add data-current classes to the button class list
$searchClass = 'hover:text-zinc-800 dark:text-white/80 in-data-flux-menu:dark:text-white dark:hover:text-white';
$replaceClass = $searchClass.' data-current:text-(--color-accent-content) data-current:bg-white dark:data-current:bg-white/[7%] data-current:border-zinc-200 dark:data-current:border-transparent';

$content = str_replace($searchClass, $replaceClass, $content);

file_put_contents($file, $content);
echo "Patched group blade.\n";

<?php

$file = 'resources/views/flux/sidebar/group.blade.php';
$content = file_get_contents($file);

$iconClass = 'in-data-flux-menu:[[data-flux-sidebar-group-dropdown]>button:hover_&]:text-current';
$newIconClass = $iconClass.' [[data-current]_&]:text-current!';

$content = str_replace($iconClass, $newIconClass, $content);
file_put_contents($file, $content);

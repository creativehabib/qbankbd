<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

// Replace the junk left behind by the bad regex
$content = preg_replace('/\? \$[a-zA-Z0-9_]+ : \(\$[a-zA-Z0-9_]+ \? asset\(\'storage\/\'\.\$[a-zA-Z0-9_]+\) : \'\'\),\n\s*\]\)/', '', $content);

file_put_contents($file, $content);

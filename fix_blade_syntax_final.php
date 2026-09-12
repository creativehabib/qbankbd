<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

// Remove the junk: ? $prop : ($prop ? asset('storage/'.$prop) : ''), ])
$content = preg_replace('/\? \$[a-zA-Z0-9_]+ \: \(\$[a-zA-Z0-9_]+ \? asset\(\'storage\/\'\.\$[a-zA-Z0-9_]+\) \: \'\'\),\n\s*\]\)/', '', $content);
$content = preg_replace('/\? \$[a-zA-Z0-9_]+ \: \(\$[a-zA-Z0-9_]+ \? asset\(\'storage\/\'\.\$[a-zA-Z0-9_]+\) \: \'\'\),\s*\]\)/', '', $content);
$content = preg_replace('/\? \$[a-zA-Z0-9_]+ \: \(\$[a-zA-Z0-9_]+ \? asset\(\'storage\/\'\.\$[a-zA-Z0-9_]+\) \: \'\'\),/', '', $content);
$content = preg_replace('/\]\)/', '', $content);

file_put_contents($file, $content);

<?php
$file = 'resources/views/frontend/scripts.blade.php';
$content = file_get_contents($file);

// Remove the livewire:navigated line
$content = preg_replace('/document\.addEventListener\(\'livewire:navigated\', initThemeToggle\);\n?/', '', $content);

file_put_contents($file, $content);
echo "Cleaned up scripts.blade.php\n";

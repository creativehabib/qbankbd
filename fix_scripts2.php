<?php
$file = 'resources/views/frontend/scripts.blade.php';
$content = file_get_contents($file);

// Remove the initThemeToggle block
$content = preg_replace('/function initThemeToggle\(\) \{[\s\S]*?\}\n\s*window\.addEventListener\(\'DOMContentLoaded\', initThemeToggle\);\n*/', '', $content);

file_put_contents($file, $content);
echo "Removed duplicate theme JS from scripts.blade.php\n";

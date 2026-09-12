<?php

$file = 'app/Livewire/Tags/Index.php';
$content = file_get_contents($file);

if (! str_contains($content, '$isCreating')) {
    $content = preg_replace('/class [a-zA-Z0-9_]+ extends Component\s*\{/', "$0\n    public \$isCreating = false;\n", $content);
}

$content = preg_replace('/public function edit\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);
$content = preg_replace('/public function cancelEdit\s*\([^)]*\)\s*(:\s*void\s*)?\{/', "$0\n        \$this->isCreating = false;", $content);

file_put_contents($file, $content);

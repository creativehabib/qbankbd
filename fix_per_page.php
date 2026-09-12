<?php

$files = glob('app/Livewire/*/*.php');
$files = array_merge($files, glob('app/Livewire/*/*/*.php'));

foreach ($files as $file) {
    if (! str_contains(file_get_contents($file), '$perPage')) {
        $content = file_get_contents($file);

        // Find class declaration and insert after first {
        $content = preg_replace('/class [a-zA-Z0-9_]+ extends Component\s*\{/', "$0\n    public \$perPage = 10;\n", $content);

        file_put_contents($file, $content);
        echo "Added perPage to $file\n";
    }
}

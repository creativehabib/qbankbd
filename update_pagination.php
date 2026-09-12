<?php

$files = glob('app/Livewire/*/*.php');
$files = array_merge($files, glob('app/Livewire/*/*/*.php'));

foreach ($files as $file) {
    if (! str_contains(file_get_contents($file), 'paginate(')) {
        continue;
    }

    $content = file_get_contents($file);

    // Add public $perPage = 10; if not exists
    if (! str_contains($content, '$perPage')) {
        $content = preg_replace('/public \$search = \'\';/', "public \$search = '';\n    public \$perPage = 10;", $content);
    }

    // Replace ->paginate(10) or ->paginate(15) with ->paginate($this->perPage)
    $content = preg_replace('/->paginate\(\d+\)/', '->paginate($this->perPage)', $content);

    file_put_contents($file, $content);
    echo "Updated pagination in $file\n";
}

<?php

$files = [
    'resources/views/components/app-logo.blade.php',
    'resources/views/partials/head.blade.php',
];

foreach ($files as $file) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    // Replace asset('storage/'.$branding['...']) with \Illuminate\Support\Str::startsWith($branding['...'], 'http') ? $branding['...'] : asset('storage/'.$branding['...'])
    $content = preg_replace_callback('/asset\(\'storage\/\'\s*\.\s*(\$branding\[\'[a-zA-Z_]+\'\])\)/', function ($matches) {
        $var = $matches[1];

        return "\\Illuminate\\Support\\Str::startsWith($var, ['http://', 'https://']) ? $var : asset('storage/'.$var)";
    }, $content);

    file_put_contents($file, $content);
    echo "Fixed $file\n";
}

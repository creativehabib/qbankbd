<?php

$file = 'resources/views/components/modern-image-uploader.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    "'previewHeight' => 'h-32',",
    "'previewHeight' => 'h-32',\n    'mode' => 'auto', // auto, light, dark",
    $content
);

$phpBlock = <<<'PHP'
@php
    $inputId = 'file_input_' . Str::random(8);
    
    // Determine background and grid colors based on mode
    if ($mode === 'light') {
        $bgClass = 'bg-zinc-50 border-zinc-200';
        $gridColor = 'var(--color-zinc-200)';
    } elseif ($mode === 'dark') {
        $bgClass = 'bg-zinc-900 border-zinc-800';
        $gridColor = 'var(--color-zinc-800)';
    } else {
        $bgClass = 'bg-zinc-50/50 dark:bg-zinc-900/50 border-zinc-200 dark:border-zinc-800';
        $gridColor = 'var(--color-zinc-300)'; // Will just use one color for auto for simplicity, or we can use CSS vars.
    }
@endphp
PHP;

$content = preg_replace('/@php(.*?)@endphp/s', $phpBlock, $content);

$content = str_replace(
    '<div class="relative w-full {{ $previewHeight }} bg-zinc-50/50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-lg flex items-center justify-center overflow-hidden" 
         style="background-image: radial-gradient(var(--color-zinc-300) 1px, transparent 0); background-size: 10px 10px;">',
    '<div class="relative w-full {{ $previewHeight }} {{ $bgClass }} border rounded-lg flex items-center justify-center overflow-hidden" 
         style="background-image: radial-gradient({{ $gridColor }} 1px, transparent 0); background-size: 10px 10px;">',
    $content
);

file_put_contents($file, $content);

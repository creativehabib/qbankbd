<?php

$file = 'resources/views/components/modern-image-uploader.blade.php';
$content = file_get_contents($file);

$content = str_replace(
    "'previewHeight' => 'h-32',\n    'mode' => 'auto', // auto, light, dark",
    "'previewHeight' => 'h-32',\n    'mode' => 'auto', // auto, light, dark\n    'emptyTitle' => 'Drag the image or click to browse',\n    'emptyHint' => 'PNG, JPG, or WebP · up to 2MB',",
    $content
);

// We need to change border and cursor if empty
$phpBlock = <<<'PHP'
@php
    $inputId = 'file_input_' . Str::random(8);
    $hasImage = $upload || $existing;
    
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
    
    $borderClass = $hasImage ? 'border-solid' : 'border-dashed cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800/80 transition-colors';
@endphp
PHP;

$content = preg_replace('/@php(.*?)@endphp/s', $phpBlock, $content);

$imageContainer = <<<BLADE
    <div class="relative w-full {{ \$previewHeight }} {{ \$bgClass }} {{ \$borderClass }} border-2 rounded-lg flex flex-col items-center justify-center overflow-hidden" 
         style="background-image: radial-gradient({{ \$gridColor }} 1px, transparent 0); background-size: 10px 10px;"
         @if(!\$hasImage) onclick="document.getElementById('{{ \$inputId }}').click()" @endif>
        
        @if (\$upload)
            <img src="{{ \$upload->temporaryUrl() }}" class="max-h-full max-w-full object-contain p-2">
        @elseif (\$existing)
            <img src="{{ \Illuminate\Support\Str::startsWith(\$existing, ['http://', 'https://']) ? \$existing : asset('storage/'.\$existing) }}" class="max-h-full max-w-full object-contain p-2">
        @else
            <!-- Empty state -->
            <div class="flex flex-col items-center justify-center p-4 text-center">
                <div class="size-8 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center mb-3 shadow-sm">
                    <flux:icon icon="arrow-down-tray" class="size-4 text-zinc-500 dark:text-zinc-400" />
                </div>
                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300">{{ \$emptyTitle }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">{{ \$emptyHint }}</p>
            </div>
        @endif
        
    </div>
BLADE;

$content = preg_replace('/<div class="relative w-full \{\{ \$previewHeight \}\}.*?<\/div>/s', $imageContainer, $content);

$buttonsBlock = <<<'BLADE'
    @if($hasImage)
        <div class="flex items-center gap-2 mt-2">
            <input type="file" id="{{ $inputId }}" class="hidden" wire:model="{{ $uploadModel }}" accept="image/*">
            
            <flux:button type="button" size="sm" variant="subtle" icon="pencil-square" onclick="document.getElementById('{{ $inputId }}').click()">
                Replace
            </flux:button>
            
            <flux:button type="button" size="sm" variant="subtle" icon="trash" wire:click="$set('{{ $existingModel }}', null); $set('{{ $uploadModel }}', null)">
                Remove
            </flux:button>
        </div>
    @else
        <input type="file" id="{{ $inputId }}" class="hidden" wire:model="{{ $uploadModel }}" accept="image/*">
    @endif
BLADE;

$content = preg_replace('/<div class="flex items-center gap-2 mt-2">.*?<\/div>/s', $buttonsBlock, $content);

file_put_contents($file, $content);

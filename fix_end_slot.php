<?php

$file = 'resources/views/components/modern-list-item.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
        @if(isset($end))
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $end }}
            </div>
        @endif
BLADE;

$replace = <<<'BLADE'
        @if(isset($end))
            <div class="flex items-center gap-3">
                {{ $end }}
            </div>
        @endif
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

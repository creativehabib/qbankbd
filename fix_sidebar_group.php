<?php

$file = 'resources/views/layouts/app/sidebar.blade.php';
$content = file_get_contents($file);

// Find the @foreach inside flux:sidebar.group and wrap it with <div class="flex flex-col w-full">
// The block looks like:
/*
                @elseif($item['type'] === 'group')
                    <flux:sidebar.group expandable :icon="$item['icon']" :heading="$item['label']" :expanded="$item['active']">
                        @foreach($item['items'] as $subItem)
                            @if($subItem['visible'])
                                <flux:sidebar.item ...>
                                    {{ $subItem['label'] }}
                                </flux:sidebar.item>
                            @endif
                        @endforeach
                    </flux:sidebar.group>
*/
$content = preg_replace('/(@foreach\(\$item\[\'items\'\] as \$subItem\).*?@endforeach)/s', "<div class=\"flex flex-col w-full space-y-1\">\n                            $1\n                        </div>", $content);

file_put_contents($file, $content);

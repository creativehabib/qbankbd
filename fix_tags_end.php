<?php

$file = 'resources/views/livewire/admin/tags/index.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
                <x-modern-list-item 
                    :active="$editingId === $tag->id"
                    icon="tag"
                    title="{{ $tag->name }}"
                    editAction="{{ $canUpdate ? 'edit('.$tag->id.')' : null }}"
                    deleteAction="{{ $canDelete ? 'delete('.$tag->id.')' : null }}"
                >
                    
                </x-modern-list-item>
BLADE;

$replace = <<<'BLADE'
                <x-modern-list-item 
                    :active="$editingId === $tag->id"
                    icon="tag"
                    title="{{ $tag->name }}"
                    editAction="{{ $canUpdate ? 'edit('.$tag->id.')' : null }}"
                    deleteAction="{{ $canDelete ? 'delete('.$tag->id.')' : null }}"
                >
                    <x-slot:end>
                        <div class="flex items-center gap-1.5 text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md" title="Questions Count">
                            <flux:icon icon="document-text" class="size-3.5" />
                            {{ $tag->questions_count ?? 0 }}
                        </div>
                    </x-slot:end>
                </x-modern-list-item>
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

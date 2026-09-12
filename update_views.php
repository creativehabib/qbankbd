<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => ['var' => 'editId', 'title' => 'Select a topic', 'desc' => 'Pick a row to view its details, or click "New topic" to add one.', 'model' => 'topics', 'newBtn' => 'New topic', 'icon' => 'hashtag'],
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['var' => 'editId', 'title' => 'Select a chapter', 'desc' => 'Pick a row to view its details, or click "New chapter" to add one.', 'model' => 'chapters', 'newBtn' => 'New chapter', 'icon' => 'document-text'],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['var' => 'editingClassId', 'title' => 'Select a class', 'desc' => 'Pick a row to view its details, or click "New class" to add one.', 'model' => 'academicClasses', 'newBtn' => 'New class', 'icon' => 'academic-cap'],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['var' => 'editId', 'title' => 'Select an exam', 'desc' => 'Pick a row to view its details, or click "New exam" to add one.', 'model' => 'examCategories', 'newBtn' => 'New exam', 'icon' => 'academic-cap'],
    'resources/views/livewire/admin/tags/index.blade.php' => ['var' => 'editingId', 'title' => 'Select a tag', 'desc' => 'Pick a row to view its details, or click "New tag" to add one.', 'model' => 'tags', 'newBtn' => 'New tag', 'icon' => 'tag'],
];

foreach ($files as $file => $config) {
    $content = file_get_contents($file);

    // Replace <form wire:submit... with alpine wrapper
    $formStartStr = '<form wire:submit=';
    $formStartPos = strpos($content, $formStartStr);

    // Find the end of the form tag to insert x-show
    $formTagEnd = strpos($content, '>', $formStartPos);

    // Build new form wrapper
    $alpineWrapper = "<div x-data=\"{ isCreating: false }\" x-on:start-creating.window=\"isCreating = true; \$wire.cancelEdit()\" x-on:edit-item.window=\"isCreating = false\">\n";
    $alpineWrapper .= '            <div x-show="!isCreating && !{{ $'.$config['var'].' ? \'true\' : \'false\' }}">'."\n";
    $alpineWrapper .= '                <x-modern-empty-state icon="'.$config['icon'].'" title="'.$config['title'].'" description=\''.$config['desc'].'\' />'."\n";
    $alpineWrapper .= "            </div>\n\n";
    $alpineWrapper .= '            ';

    // Extract everything before form
    $beforeForm = substr($content, 0, $formStartPos);
    // Extract the form tag itself
    $formTag = substr($content, $formStartPos, $formTagEnd - $formStartPos + 1);

    // Add x-show and x-cloak to form tag
    $newFormTag = str_replace('>', ' x-show="isCreating || {{ $'.$config['var'].' ? \'true\' : \'false\' }}" x-cloak>', $formTag);

    // Extract the rest
    $rest = substr($content, $formTagEnd + 1);

    // Replace Cancel button
    // Find cancel button: <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
    // Note: class-index uses resetClassForm instead of cancelEdit
    $rest = preg_replace('/<flux:button type="button" wire:click="[^"]+" variant="ghost">Cancel<\/flux:button>/', '<flux:button type="button" x-on:click="isCreating = false; \$wire.cancelEdit ? \$wire.cancelEdit() : \$wire.resetClassForm()" variant="ghost">Cancel</flux:button>', $rest);

    // Remove @if($editId) and @endif around cancel button
    $rest = preg_replace('/@if\(\$.*?\)\s*(<flux:button type="button" x-on:click="isCreating = false; \$wire\..*?\(\)" variant="ghost">Cancel<\/flux:button>)\s*@endif/s', '$1', $rest);

    // Add closing div for alpine wrapper before </x-slot:form>
    $rest = str_replace('</x-slot:form>', "    </div>\n    </x-slot:form>", $rest);

    // Now replace search input and header
    // Remove the old search div:
    // <div class="mt-4">
    //      <flux:input ... />
    // </div>
    // Note: search variable might be 'search' or 'classSearch'
    $searchModel = 'search';
    if (strpos($rest, 'wire:model.live.debounce.300ms="classSearch"') !== false) {
        $searchModel = 'classSearch';
    }

    $rest = preg_replace('/<div class="mt-4">\s*<flux:input[^>]+>\s*<\/div>/s', '', $rest);

    // Add New Button to header
    $headerEndStr = "</div>\n            </div>";
    if (strpos($rest, $headerEndStr) !== false) {
        $newBtnHtml = "</div>\n                <div class=\"flex items-center gap-2\">\n                    <flux:button variant=\"primary\" icon=\"plus\" x-on:click=\"\$dispatch('start-creating')\">".$config['newBtn']."</flux:button>\n                </div>\n            </div>";
        $rest = preg_replace('/<\/div>\s*<\/div>\s*<\/div>\s*<x-modern-list>/', $newBtnHtml."\n        </div>\n        <x-modern-list-header :total=\"\$".$config['model'].'->total()" model="'.$searchModel."\" />\n\n        <x-modern-list>", $rest);
    }

    $finalContent = $beforeForm.$alpineWrapper.$newFormTag.$rest;

    file_put_contents($file, $finalContent);
    echo "Updated $file\n";
}

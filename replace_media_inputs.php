<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$replacements = [
    [
        'prop' => 'logo_light',
        'label' => 'Light Mode',
    ],
    [
        'prop' => 'logo_dark',
        'label' => 'Dark Mode',
    ],
    [
        'prop' => 'icon_light',
        'label' => 'Light Mode',
    ],
    [
        'prop' => 'icon_dark',
        'label' => 'Dark Mode',
    ],
    [
        'prop' => 'favicon',
        'label' => 'Upload Favicon',
    ],
];

foreach ($replacements as $rep) {
    $prop = $rep['prop'];
    $label = $rep['label'];

    // Create the replacement HTML
    $replacement = <<<BLADE
                            <flux:label>{$label}</flux:label>
                            @if(\${$prop})
                                <div class="mb-2">
                                    <img src="{{ \Illuminate\Support\Str::startsWith(\${$prop}, ['http://', 'https://']) ? \${$prop} : asset('storage/'.\${$prop}) }}" class="h-12 object-contain bg-zinc-100 dark:bg-zinc-800 p-1 rounded border dark:border-zinc-700">
                                </div>
                            @endif
                            <flux:input type="file" wire:model="{$prop}_upload" accept="image/*" />
BLADE;

    // Use regex to find and replace the @include block
    // We match from @include("mediamanager::includes.media-input" to the closing ])
    $pattern = '/@include\("mediamanager::includes\.media-input",\s*\[\s*"name"\s*=>\s*"'.$prop.'"[^\]]+\]\)/s';

    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);

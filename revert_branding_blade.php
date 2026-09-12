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

    // The pattern to match what we put earlier
    // <flux:label>{$label}</flux:label> ... <flux:input type="file" wire:model="{$prop}_upload" accept="image/*" />
    $pattern = '/<flux:label>'.preg_quote($label).'<\/flux:label>.*?<flux:input type="file" wire:model="'.preg_quote($prop.'_upload').'" accept="image\/\*" \/>/s';

    // The replacement
    $replacement = <<<BLADE
                            @include("mediamanager::includes.media-input", [
                                "name"  => "{$prop}",
                                "id"    => "{$prop}",
                                "label" => "{$label}",
                                "value" => \Illuminate\Support\Str::startsWith(\${$prop} ?? '', ['http://', 'https://']) ? \${$prop} : (\${$prop} ? asset('storage/'.\${$prop}) : ''),
                            ])
BLADE;
    if ($prop === 'favicon') {
        $replacement = <<<BLADE
                    @include("mediamanager::includes.media-input", [
                        "name"  => "{$prop}",
                        "id"    => "{$prop}",
                        "label" => "{$label}",
                        "value" => \Illuminate\Support\Str::startsWith(\${$prop} ?? '', ['http://', 'https://']) ? \${$prop} : (\${$prop} ? asset('storage/'.\${$prop}) : ''),
                    ])
BLADE;
    }

    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);

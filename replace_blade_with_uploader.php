<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$replacements = [
    [
        'prop' => 'logo_light',
        'label' => 'LIGHT MODE',
        'height' => 'h-32',
    ],
    [
        'prop' => 'logo_dark',
        'label' => 'DARK MODE',
        'height' => 'h-32',
    ],
    [
        'prop' => 'icon_light',
        'label' => 'LIGHT MODE',
        'height' => 'h-48',
    ],
    [
        'prop' => 'icon_dark',
        'label' => 'DARK MODE',
        'height' => 'h-48',
    ],
    [
        'prop' => 'favicon',
        'label' => '',
        'height' => 'h-48',
    ],
];

foreach ($replacements as $rep) {
    $prop = $rep['prop'];
    $label = $rep['label'];
    $height = $rep['height'];

    // The replacement
    $replacement = <<<BLADE
                            <x-modern-image-uploader 
                                label="{$label}" 
                                uploadModel="{$prop}_upload" 
                                existingModel="{$prop}" 
                                previewHeight="{$height}" 
                            />
BLADE;

    // Use regex to find and replace the @include block
    // Since we reverted it, it's currently using mediamanager again
    $pattern = '/@include\("mediamanager::includes\.media-input",\s*\[\s*"name"\s*=>\s*"'.$prop.'"[^\]]+\]\)/s';

    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);

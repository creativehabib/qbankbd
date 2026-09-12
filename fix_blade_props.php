<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$replacements = [
    'logo_light', 'logo_dark', 'icon_light', 'icon_dark', 'favicon',
];

foreach ($replacements as $prop) {
    $search = <<<BLADE
                                uploadModel="{$prop}_upload" 
                                existingModel="{$prop}"
BLADE;

    $replace = <<<BLADE
                                uploadModel="{$prop}_upload" 
                                :upload="\${$prop}_upload"
                                existingModel="{$prop}" 
                                :existing="\${$prop}"
BLADE;

    $content = str_replace($search, $replace, $content);
}

file_put_contents($file, $content);

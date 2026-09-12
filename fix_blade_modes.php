<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$replacements = [
    'logo_light' => 'light',
    'logo_dark' => 'dark',
    'icon_light' => 'light',
    'icon_dark' => 'dark',
    'favicon' => 'auto', // auto or light
];

foreach ($replacements as $prop => $mode) {
    $search = <<<BLADE
                                uploadModel="{$prop}_upload" 
                                :upload="\${$prop}_upload"
                                existingModel="{$prop}" 
                                :existing="\${$prop}" 
BLADE;

    $replace = <<<BLADE
                                uploadModel="{$prop}_upload" 
                                :upload="\${$prop}_upload"
                                existingModel="{$prop}" 
                                :existing="\${$prop}"
                                mode="{$mode}"
BLADE;

    $content = str_replace($search, $replace, $content);
}

file_put_contents($file, $content);

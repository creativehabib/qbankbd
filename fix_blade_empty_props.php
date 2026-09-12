<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

// Full logo
$searchLogo = <<<'BLADE'
                                uploadModel="logo_light_upload" 
                                :upload="$logo_light_upload"
                                existingModel="logo_light" 
                                :existing="$logo_light"
                                mode="light"
BLADE;
$replaceLogo = $searchLogo."\n                                emptyTitle=\"Drag the app logo or click to browse\"\n                                emptyHint=\"PNG, JPG, or WebP · up to 2048 KB\"";
$content = str_replace($searchLogo, $replaceLogo, $content);

$searchLogoDark = <<<'BLADE'
                                uploadModel="logo_dark_upload" 
                                :upload="$logo_dark_upload"
                                existingModel="logo_dark" 
                                :existing="$logo_dark"
                                mode="dark"
BLADE;
$replaceLogoDark = $searchLogoDark."\n                                emptyTitle=\"Drag the app logo or click to browse\"\n                                emptyHint=\"PNG, JPG, or WebP · up to 2048 KB\"";
$content = str_replace($searchLogoDark, $replaceLogoDark, $content);

// Icon
$searchIcon = <<<'BLADE'
                                uploadModel="icon_light_upload" 
                                :upload="$icon_light_upload"
                                existingModel="icon_light" 
                                :existing="$icon_light"
                                mode="light"
BLADE;
$replaceIcon = $searchIcon."\n                                emptyTitle=\"Drag the icon/mark or click to browse\"\n                                emptyHint=\"PNG, JPG, or WebP · up to 2048 KB\"";
$content = str_replace($searchIcon, $replaceIcon, $content);

$searchIconDark = <<<'BLADE'
                                uploadModel="icon_dark_upload" 
                                :upload="$icon_dark_upload"
                                existingModel="icon_dark" 
                                :existing="$icon_dark"
                                mode="dark"
BLADE;
$replaceIconDark = $searchIconDark."\n                                emptyTitle=\"Drag the icon/mark or click to browse\"\n                                emptyHint=\"PNG, JPG, or WebP · up to 2048 KB\"";
$content = str_replace($searchIconDark, $replaceIconDark, $content);

// Favicon
$searchFav = <<<'BLADE'
                                uploadModel="favicon_upload" 
                                :upload="$favicon_upload"
                                existingModel="favicon" 
                                :existing="$favicon"
                                mode="auto"
BLADE;
$replaceFav = $searchFav."\n                                emptyTitle=\"Drag a favicon or click to browse\"\n                                emptyHint=\"PNG, JPG, or ICO · up to 1024 KB\"";
$content = str_replace($searchFav, $replaceFav, $content);

file_put_contents($file, $content);

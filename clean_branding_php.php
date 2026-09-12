<?php

$file = 'app/Livewire/Admin/Settings/BrandingTheme.php';
$content = file_get_contents($file);

$content = preg_replace('/public \$[a-z_]+_upload;/s', '', $content);
$content = str_replace('use WithFileUploads;', '', $content);
$content = str_replace('use Livewire\WithFileUploads;', '', $content);

file_put_contents($file, $content);
echo "Cleaned BrandingTheme.php\n";

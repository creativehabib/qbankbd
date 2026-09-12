<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

function replaceUploader($content, $label, $name, $regexStr)
{
    $replacement = <<<BLADE
<div class="space-y-2">
                            @include('mediamanager::includes.media-input', [
                                'name'  => '{$name}',
                                'id'    => '{$name}',
                                'label' => '{$label}',
                                'value' => \Illuminate\Support\Str::startsWith(\${$name} ?? '', ['http://', 'https://']) ? \${$name} : (\${$name} ? asset('storage/'.\${$name}) : ''),
                            ])
                        </div>
BLADE;

    return preg_replace($regexStr, $replacement, $content);
}

$content = replaceUploader($content, 'Light Mode', 'logo_light', '/<div class="space-y-2">\s*<label[^>]*>Light Mode<\/label>\s*<div class="border border-dashed[^>]*>.*?<\/div>\s*<\/div>/s');
// Because there are two "Light Mode" (logo and icon), the regex above will replace both if I use preg_replace directly? No, the regex will match the first one, or all of them!
// Wait, the regex `.*?` is ungreedy, so it will match the inner div.
// Let's do a more precise replacement script.

<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

function replaceLogoSection($content, $label, $name)
{
    // The section starts with <div class="space-y-2"> and ends with </div> just before the next <div class="space-y-2"> or </div>
    // It's easier to regex replace based on the wire:model="..._upload"

    $regex = '/<div class="space-y-2">\s*<label[^>]*>'.$label.'<\/label>.*?<\/div>\s*<\/div>/s';

    $replacement = <<<BLADE
<div class="space-y-2">
                            @include('mediamanager::includes.media-input', [
                                'name'  => '{$name}',
                                'id'    => '{$name}',
                                'label' => '{$label}',
                                'value' => \Illuminate\Support\Str::startsWith(\${$name}, ['http://', 'https://']) ? \${$name} : (\${$name} ? asset('storage/'.\${$name}) : ''),
                            ])
                        </div>
BLADE;

    return preg_replace($regex, $replacement, $content);
}

$content = replaceLogoSection($content, 'Light Mode', 'logo_light');
$content = replaceLogoSection($content, 'Dark Mode', 'logo_dark');
// Wait, the icon section has the same labels "Light Mode" and "Dark Mode".
// Let's replace manually or use a smarter script.

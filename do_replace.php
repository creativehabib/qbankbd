<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

// 1. logo_light
$content = preg_replace('/<div class="space-y-2">\s*<label[^>]*>Light Mode<\/label>\s*<div class="border border-dashed[^>]*>.*?(logo_light_upload).*?<\/div>\s*<\/div>/s', '
                        <div class="space-y-2">
                            @include("mediamanager::includes.media-input", [
                                "name"  => "logo_light",
                                "id"    => "logo_light",
                                "label" => "Light Mode",
                                "value" => \Illuminate\Support\Str::startsWith($logo_light ?? \'\', [\'http://\', \'https://\']) ? $logo_light : ($logo_light ? asset(\'storage/\'.$logo_light) : \'\'),
                            ])
                        </div>
', $content);

// 2. logo_dark
$content = preg_replace('/<div class="space-y-2">\s*<label[^>]*>Dark Mode<\/label>\s*<div class="border border-dashed[^>]*>.*?(logo_dark_upload).*?<\/div>\s*<\/div>/s', '
                        <div class="space-y-2">
                            @include("mediamanager::includes.media-input", [
                                "name"  => "logo_dark",
                                "id"    => "logo_dark",
                                "label" => "Dark Mode",
                                "value" => \Illuminate\Support\Str::startsWith($logo_dark ?? \'\', [\'http://\', \'https://\']) ? $logo_dark : ($logo_dark ? asset(\'storage/\'.$logo_dark) : \'\'),
                            ])
                        </div>
', $content);

// 3. icon_light
$content = preg_replace('/<div class="space-y-2">\s*<label[^>]*>Light Mode<\/label>\s*<div class="border border-dashed[^>]*>.*?(icon_light_upload).*?<\/div>\s*<\/div>/s', '
                        <div class="space-y-2">
                            @include("mediamanager::includes.media-input", [
                                "name"  => "icon_light",
                                "id"    => "icon_light",
                                "label" => "Light Mode",
                                "value" => \Illuminate\Support\Str::startsWith($icon_light ?? \'\', [\'http://\', \'https://\']) ? $icon_light : ($icon_light ? asset(\'storage/\'.$icon_light) : \'\'),
                            ])
                        </div>
', $content);

// 4. icon_dark
$content = preg_replace('/<div class="space-y-2">\s*<label[^>]*>Dark Mode<\/label>\s*<div class="border border-dashed[^>]*>.*?(icon_dark_upload).*?<\/div>\s*<\/div>/s', '
                        <div class="space-y-2">
                            @include("mediamanager::includes.media-input", [
                                "name"  => "icon_dark",
                                "id"    => "icon_dark",
                                "label" => "Dark Mode",
                                "value" => \Illuminate\Support\Str::startsWith($icon_dark ?? \'\', [\'http://\', \'https://\']) ? $icon_dark : ($icon_dark ? asset(\'storage/\'.$icon_dark) : \'\'),
                            ])
                        </div>
', $content);

// 5. favicon
$content = preg_replace('/<div class="border border-dashed[^>]*>.*?(favicon_upload).*?<\/div>/s', '
                <div>
                    @include("mediamanager::includes.media-input", [
                        "name"  => "favicon",
                        "id"    => "favicon",
                        "label" => "Upload Favicon",
                        "value" => \Illuminate\Support\Str::startsWith($favicon ?? \'\', [\'http://\', \'https://\']) ? $favicon : ($favicon ? asset(\'storage/\'.$favicon) : \'\'),
                    ])
                </div>
', $content);

file_put_contents($file, $content);
echo "Replaced properly.\n";

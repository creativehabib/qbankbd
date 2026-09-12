<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$search = <<<BLADE
                <div>
                    @include("mediamanager::includes.media-input", [
                        "name"  => "favicon",
                        "id"    => "favicon",
                        "label" => "Upload Favicon",
                        "value" => \Illuminate\Support\Str::startsWith(\$favicon ?? '', ['http://', 'https://']) ? \$favicon : (\$favicon ? asset('storage/'.\$favicon) : ''),
                    ])
                </div>

                    @endif
                    <input type="file" wire:model="favicon_upload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/png, image/jpeg, image/x-icon" />
                </div>
BLADE;

$replace = <<<BLADE
                <div>
                    @include("mediamanager::includes.media-input", [
                        "name"  => "favicon",
                        "id"    => "favicon",
                        "label" => "Upload Favicon",
                        "value" => \Illuminate\Support\Str::startsWith(\$favicon ?? '', ['http://', 'https://']) ? \$favicon : (\$favicon ? asset('storage/'.\$favicon) : ''),
                    ])
                </div>
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

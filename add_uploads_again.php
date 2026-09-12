<?php

$file = 'app/Livewire/Admin/Settings/BrandingTheme.php';
$content = file_get_contents($file);

// Add WithFileUploads
if (! str_contains($content, 'use Livewire\WithFileUploads;')) {
    $content = str_replace('use Livewire\Component;', "use Livewire\Component;\nuse Livewire\WithFileUploads;", $content);
    $content = preg_replace('/class BrandingTheme extends Component\n\{/', "class BrandingTheme extends Component\n{\n    use WithFileUploads;\n", $content);
}

// Add upload properties
$uploadProps = <<<'PHP'
    public $logo_light_upload;
    public $logo_dark_upload;
    public $icon_light_upload;
    public $icon_dark_upload;
    public $favicon_upload;
PHP;

if (! str_contains($content, '$logo_light_upload')) {
    $content = preg_replace('/(public string \$default_theme = \'Dark\';)/', "$1\n\n$uploadProps", $content);
}

// Add validation for uploads
$validationRules = <<<'PHP'
            'logo_light_upload' => ['nullable', 'image', 'max:2048'],
            'logo_dark_upload' => ['nullable', 'image', 'max:2048'],
            'icon_light_upload' => ['nullable', 'image', 'max:2048'],
            'icon_dark_upload' => ['nullable', 'image', 'max:2048'],
            'favicon_upload' => ['nullable', 'image', 'max:1024'],
PHP;
if (! str_contains($content, 'logo_light_upload')) {
    $content = preg_replace('/(\'default_theme\' => \[\'required\', \'string\', \'in:Dark,Light,System\'\],)/', "$1\n$validationRules", $content);
}

// Add saving logic
$savingLogic = <<<'PHP'
        if ($this->logo_light_upload) {
            $this->logo_light = $this->logo_light_upload->store('branding', 'public');
        }
        if ($this->logo_dark_upload) {
            $this->logo_dark = $this->logo_dark_upload->store('branding', 'public');
        }
        if ($this->icon_light_upload) {
            $this->icon_light = $this->icon_light_upload->store('branding', 'public');
        }
        if ($this->icon_dark_upload) {
            $this->icon_dark = $this->icon_dark_upload->store('branding', 'public');
        }
        if ($this->favicon_upload) {
            $this->favicon = $this->favicon_upload->store('branding', 'public');
        }
PHP;
if (! str_contains($content, '$this->logo_light_upload->store')) {
    $content = preg_replace('/(SettingsStore::saveGroup\(\'branding\', \[)/', "$savingLogic\n\n        $1", $content);
}

file_put_contents($file, $content);

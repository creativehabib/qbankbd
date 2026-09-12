<?php

$file = 'app/Livewire/Admin/Settings/BrandingTheme.php';
$content = file_get_contents($file);

// Remove the validation rules for the _upload fields
$content = preg_replace('/\'logo_light_upload\' => \[\'nullable\', \'image\', \'max:2048\'\],.*?\'favicon_upload\' => \[\'nullable\', \'image\', \'max:1024\'\],/s', '', $content);

// Also remove the storing logic:
$storingLogic = <<<'PHP'
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

$content = str_replace($storingLogic, '', $content);

file_put_contents($file, $content);
echo "Updated BrandingTheme.php\n";

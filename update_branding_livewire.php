<?php

$file = 'app/Livewire/Admin/Settings/BrandingTheme.php';
$content = file_get_contents($file);

$search = "        \$this->dispatch('branding-saved');\n    }";
$replace = "        \$this->dispatch('branding-saved');\n        \$this->dispatch('default-theme-updated', theme: strtolower(trim(\$validated['default_theme'])));\n    }";

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

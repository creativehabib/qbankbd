<?php

namespace App\Livewire\Admin\Settings;

use App\Support\SettingsStore;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandingTheme extends Component
{
    use WithFileUploads;

    public $perPage = 10;

    public string $app_name = 'Hyper POS';

    public string $footer_text = '© 2026 Hyper POS. All rights reserved.';

    public string $accent_color = '#3b82f6';

    public string $text_color = '#ffffff';

    public string $dark_bg_color = '#020818';

    public string $default_theme = 'Dark';

    public $logo_light_upload;

    public $logo_dark_upload;

    public $icon_light_upload;

    public $icon_dark_upload;

    public $favicon_upload;

    // Existing paths
    public ?string $logo_light = null;

    public ?string $logo_dark = null;

    public ?string $icon_light = null;

    public ?string $icon_dark = null;

    public ?string $favicon = null;

    public function mount()
    {
        // abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $settings = SettingsStore::group('branding');

        $this->app_name = (string) ($settings['app_name'] ?? $this->app_name);
        $this->footer_text = (string) ($settings['footer_text'] ?? $this->footer_text);
        $this->accent_color = (string) ($settings['accent_color'] ?? $this->accent_color);
        $this->text_color = (string) ($settings['text_color'] ?? $this->text_color);
        $this->dark_bg_color = (string) ($settings['dark_bg_color'] ?? $this->dark_bg_color);
        $this->default_theme = (string) ($settings['default_theme'] ?? $this->default_theme);

        $this->logo_light = (string) ($settings['logo_light'] ?? null);
        $this->logo_dark = (string) ($settings['logo_dark'] ?? null);
        $this->icon_light = (string) ($settings['icon_light'] ?? null);
        $this->icon_dark = (string) ($settings['icon_dark'] ?? null);
        $this->favicon = (string) ($settings['favicon'] ?? null);
    }

    public function save()
    {
        // abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $validated = $this->validate([
            'app_name' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'accent_color' => ['nullable', 'string', 'max:50'],
            'text_color' => ['nullable', 'string', 'max:50'],
            'dark_bg_color' => ['nullable', 'string', 'max:50'],
            'default_theme' => ['required', 'string', 'in:Dark,Light,System'],
        ]);

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

        SettingsStore::saveGroup('branding', [
            'app_name' => trim($validated['app_name'] ?? ''),
            'footer_text' => trim($validated['footer_text'] ?? ''),
            'accent_color' => trim($validated['accent_color'] ?? '#3b82f6'),
            'text_color' => trim($validated['text_color'] ?? '#ffffff'),
            'dark_bg_color' => trim($validated['dark_bg_color'] ?? '#020818'),
            'default_theme' => trim($validated['default_theme']),

            'logo_light' => $this->logo_light,
            'logo_dark' => $this->logo_dark,
            'icon_light' => $this->icon_light,
            'icon_dark' => $this->icon_dark,
            'favicon' => $this->favicon,
        ]);

        $this->dispatch('branding-saved');
        $this->dispatch('default-theme-updated', theme: strtolower(trim($validated['default_theme'])));
    }

    public function render()
    {
        return view('livewire.admin.settings.branding-theme')->layout('layouts.app', ['title' => 'Branding & Theme']);
    }
}

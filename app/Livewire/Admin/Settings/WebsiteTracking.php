<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Support\SettingsStore;
use Livewire\Component;

class WebsiteTracking extends Component
{
    use InteractsWithFluxToasts;

    public ?string $google_analytics_id = '';
    public ?string $facebook_pixel_id = '';
    public ?string $custom_header_script = '';
    public ?string $custom_footer_script = '';

    public function mount()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);
        
        $settings = SettingsStore::group('tracking');
        
        $this->google_analytics_id = $settings['google_analytics_id'] ?? '';
        $this->facebook_pixel_id = $settings['facebook_pixel_id'] ?? '';
        $this->custom_header_script = $settings['custom_header_script'] ?? '';
        $this->custom_footer_script = $settings['custom_footer_script'] ?? '';
    }

    public function save()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $validated = $this->validate([
            'google_analytics_id' => ['nullable', 'string', 'max:50'],
            'facebook_pixel_id' => ['nullable', 'string', 'max:50'],
            'custom_header_script' => ['nullable', 'string', 'max:5000'],
            'custom_footer_script' => ['nullable', 'string', 'max:5000'],
        ]);

        SettingsStore::saveGroup('tracking', $validated);

        $this->toastSuccess('Tracking settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.website-tracking')->layout('layouts.app', ['title' => 'Website Tracking']);
    }
}

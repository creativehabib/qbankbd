<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Support\SettingsStore;
use Livewire\Component;

class GeneralSetting extends Component
{
    use InteractsWithFluxToasts;

    public ?string $site_description = '';
    public ?string $support_email = '';
    public ?string $support_phone = '';
    public ?string $company_address = '';
    public ?string $system_currency = 'BDT';
    public ?string $facebook_url = '';
    public ?string $youtube_url = '';
    public ?string $linkedin_url = '';

    // New Fields
    public ?string $default_language = 'en';
    public ?string $date_format = 'Y-m-d';
    public ?string $time_format = 'H:i';
    public ?string $calendar_start_day = 'Sunday';
    public ?string $default_timezone = 'UTC';
    public bool $email_verification = false;
    public bool $landing_page = true;
    public bool $user_registration = true;
    public ?string $terms_conditions_url = '';

    public function mount()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);
        
        $settings = SettingsStore::group('general');
        
        $this->site_description = $settings['site_description'] ?? '';
        $this->support_email = $settings['support_email'] ?? '';
        $this->support_phone = $settings['support_phone'] ?? '';
        $this->company_address = $settings['company_address'] ?? '';
        $this->system_currency = $settings['system_currency'] ?? 'BDT';
        $this->facebook_url = $settings['facebook_url'] ?? '';
        $this->youtube_url = $settings['youtube_url'] ?? '';
        $this->linkedin_url = $settings['linkedin_url'] ?? '';
        
        $this->default_language = $settings['default_language'] ?? 'en';
        $this->date_format = $settings['date_format'] ?? 'Y-m-d';
        $this->time_format = $settings['time_format'] ?? 'H:i';
        $this->calendar_start_day = $settings['calendar_start_day'] ?? 'Sunday';
        $this->default_timezone = $settings['default_timezone'] ?? 'UTC';
        $this->email_verification = (bool) ($settings['email_verification'] ?? false);
        $this->landing_page = (bool) ($settings['landing_page'] ?? true);
        $this->user_registration = (bool) ($settings['user_registration'] ?? true);
        $this->terms_conditions_url = $settings['terms_conditions_url'] ?? '';
    }

    public function save()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $validated = $this->validate([
            'site_description' => ['nullable', 'string', 'max:500'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'support_phone' => ['nullable', 'string', 'max:50'],
            'company_address' => ['nullable', 'string', 'max:500'],
            'system_currency' => ['required', 'string', 'max:10'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            
            'default_language' => ['required', 'string', 'max:10'],
            'date_format' => ['required', 'string', 'max:20'],
            'time_format' => ['required', 'string', 'max:20'],
            'calendar_start_day' => ['required', 'string', 'max:15'],
            'default_timezone' => ['required', 'string', 'max:50'],
            'email_verification' => ['boolean'],
            'landing_page' => ['boolean'],
            'user_registration' => ['boolean'],
            'terms_conditions_url' => ['nullable', 'url', 'max:255'],
        ]);

        SettingsStore::saveGroup('general', $validated);

        $this->toastSuccess('General settings saved successfully.');
    }
    
    public function getTimezonesProperty(): array
    {
        $timezones = [];
        $identifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        
        foreach ($identifiers as $tz) {
            $date = new \DateTime('now', new \DateTimeZone($tz));
            $offset = $date->getOffset();
            $hours = intdiv($offset, 3600);
            $minutes = abs(intdiv($offset % 3600, 60));
            $formattedOffset = sprintf('GMT%+03d:%02d', $hours, $minutes);
            
            // Format name: America/New_York -> America/New York
            $name = str_replace(['_', '/'], [' ', ' / '], $tz);
            
            $timezones[] = [
                'value' => $tz,
                'label' => "($formattedOffset) $name",
                'offset' => $offset
            ];
        }
        
        // Sort by offset, then by name
        usort($timezones, function($a, $b) {
            if ($a['offset'] === $b['offset']) {
                return strcmp($a['label'], $b['label']);
            }
            return $a['offset'] <=> $b['offset'];
        });
        
        $result = [];
        foreach ($timezones as $tz) {
            $result[$tz['value']] = $tz['label'];
        }
        
        return $result;
    }

    public function render()
    {
        return view('livewire.admin.settings.general-setting')->layout('layouts.app', ['title' => 'General Settings']);
    }
}


<?php

namespace App\Livewire\Admin\Settings;

use App\Support\SettingsStore;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ThemeOptions extends Component
{
    protected $listeners = [
        'theme-font-selected' => 'setPrimaryFont',
    ];

    public string $primaryFont = 'Nunito';

    public string $fontWeights = '300;400;500;600;700';

    public string $bodyFontSize = '16px';

    public bool $autoload = true;

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $settings = SettingsStore::group('typography');

        if (isset($settings['theme_options']) && is_array($settings['theme_options'])) {
            $themeOptions = $settings['theme_options'];

            $this->primaryFont = (string) ($themeOptions['primary_font'] ?? $this->primaryFont);
            $this->fontWeights = (string) ($themeOptions['font_weights'] ?? $this->fontWeights);
            $this->bodyFontSize = (string) ($themeOptions['body_font_size'] ?? $this->bodyFontSize);
            $this->autoload = (bool) ($themeOptions['autoload'] ?? $this->autoload);
        }
    }

    public function setPrimaryFont(string $font): void
    {
        $this->primaryFont = $font;
    }

    public function save(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $validated = $this->validate([
            'primaryFont' => ['required', 'string', 'max:255'],
            'fontWeights' => ['nullable', 'string', 'max:255'],
            'bodyFontSize' => ['required', 'string', Rule::in(['14px', '15px', '16px', '17px', '18px'])],
            'autoload' => ['required', 'boolean'],
        ]);

        SettingsStore::saveGroup('typography', [
            'theme_options' => [
                'primary_font' => $validated['primaryFont'],
                'font_weights' => $validated['fontWeights'],
                'body_font_size' => $validated['bodyFontSize'],
                'autoload' => $validated['autoload'],
            ],
        ], $validated['autoload']);

        $this->dispatch('theme-options-saved', message: 'Typography settings saved successfully.');
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        return view('livewire.admin.settings.theme-options')
            ->layout('layouts.app', ['title' => 'Theme Options']);
    }
}

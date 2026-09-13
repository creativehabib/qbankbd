<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Support\SettingsStore;
use Livewire\Component;

class AiSetting extends Component
{
    use InteractsWithFluxToasts;

    public ?string $ai_provider = 'gemini';
    public ?string $openai_api_key = '';
    public ?string $openai_model = 'gpt-4o-mini';
    public ?string $gemini_api_key = '';
    public ?string $gemini_model = 'gemini-1.5-flash';
    public ?string $gemini_fallback_model = 'gemini-1.5-pro';
    public bool $enable_gemini_fallback = false;

    public function mount()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);
        
        $settings = SettingsStore::group('ai');
        
        $this->ai_provider = $settings['ai_provider'] ?? 'gemini';
        $this->openai_api_key = $settings['openai_api_key'] ?? '';
        $this->openai_model = $settings['openai_model'] ?? 'gpt-4o-mini';
        $this->gemini_api_key = $settings['gemini_api_key'] ?? '';
        $this->gemini_model = $settings['gemini_model'] ?? 'gemini-1.5-flash';
        $this->gemini_fallback_model = $settings['gemini_fallback_model'] ?? 'gemini-1.5-pro';
        $this->enable_gemini_fallback = (bool) ($settings['enable_gemini_fallback'] ?? false);
    }

    public function save()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $validated = $this->validate([
            'ai_provider' => ['required', 'in:openai,gemini'],
            'openai_api_key' => ['nullable', 'string'],
            'openai_model' => ['nullable', 'string'],
            'gemini_api_key' => ['nullable', 'string'],
            'gemini_model' => ['nullable', 'string'],
            'gemini_fallback_model' => ['nullable', 'string'],
            'enable_gemini_fallback' => ['boolean'],
        ]);

        SettingsStore::saveGroup('ai', $validated);

        $this->toastSuccess('AI settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.admin.settings.ai-setting')->layout('layouts.app', ['title' => 'AI Settings']);
    }
}

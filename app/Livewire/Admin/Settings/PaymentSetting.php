<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Support\SettingsStore;
use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class PaymentSetting extends Component
{
    use InteractsWithFluxToasts;

    public bool $sslcommerz_active = false;
    public ?string $sslcommerz_store_id = '';
    public ?string $sslcommerz_store_password = '';
    public bool $sslcommerz_sandbox = true;

    public bool $bkash_active = false;
    public ?string $bkash_app_key = '';
    public ?string $bkash_app_secret = '';
    public ?string $bkash_username = '';
    public ?string $bkash_password = '';
    public bool $bkash_sandbox = true;

    public bool $nagad_active = false;
    public ?string $nagad_merchant_id = '';
    public ?string $nagad_merchant_number = '';
    public ?string $nagad_public_key = '';
    public ?string $nagad_private_key = '';
    public bool $nagad_sandbox = true;

    public function mount()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);
        
        $settings = SettingsStore::group('payment');
        
        $this->sslcommerz_active = (bool) ($settings['sslcommerz_active'] ?? false);
        $this->sslcommerz_store_id = $settings['sslcommerz_store_id'] ?? '';
        $this->sslcommerz_store_password = $settings['sslcommerz_store_password'] ?? '';
        $this->sslcommerz_sandbox = (bool) ($settings['sslcommerz_sandbox'] ?? true);

        $this->bkash_active = (bool) ($settings['bkash_active'] ?? false);
        $this->bkash_app_key = $settings['bkash_app_key'] ?? '';
        $this->bkash_app_secret = $settings['bkash_app_secret'] ?? '';
        $this->bkash_username = $settings['bkash_username'] ?? '';
        $this->bkash_password = $settings['bkash_password'] ?? '';
        $this->bkash_sandbox = (bool) ($settings['bkash_sandbox'] ?? true);

        $this->nagad_active = (bool) ($settings['nagad_active'] ?? false);
        $this->nagad_merchant_id = $settings['nagad_merchant_id'] ?? '';
        $this->nagad_merchant_number = $settings['nagad_merchant_number'] ?? '';
        $this->nagad_public_key = $settings['nagad_public_key'] ?? '';
        $this->nagad_private_key = $settings['nagad_private_key'] ?? '';
        $this->nagad_sandbox = (bool) ($settings['nagad_sandbox'] ?? true);
    }

    public function save()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $validated = $this->validate([
            'sslcommerz_active' => ['boolean'],
            'sslcommerz_store_id' => ['nullable', 'string', 'max:255'],
            'sslcommerz_store_password' => ['nullable', 'string', 'max:255'],
            'sslcommerz_sandbox' => ['boolean'],

            'bkash_active' => ['boolean'],
            'bkash_app_key' => ['nullable', 'string', 'max:255'],
            'bkash_app_secret' => ['nullable', 'string', 'max:255'],
            'bkash_username' => ['nullable', 'string', 'max:255'],
            'bkash_password' => ['nullable', 'string', 'max:255'],
            'bkash_sandbox' => ['boolean'],

            'nagad_active' => ['boolean'],
            'nagad_merchant_id' => ['nullable', 'string', 'max:255'],
            'nagad_merchant_number' => ['nullable', 'string', 'max:255'],
            'nagad_public_key' => ['nullable', 'string'],
            'nagad_private_key' => ['nullable', 'string'],
            'nagad_sandbox' => ['boolean'],
        ]);

        SettingsStore::saveGroup('payment', $validated);

        // Update environment variables
        if (!empty($validated['sslcommerz_store_id'])) {
            $this->setEnvironmentValue('STORE_ID', $validated['sslcommerz_store_id']);
        }
        if (!empty($validated['sslcommerz_store_password'])) {
            $this->setEnvironmentValue('STORE_PASSWORD', $validated['sslcommerz_store_password']);
        }
        $this->setEnvironmentValue('IS_LOCALHOST', $validated['sslcommerz_sandbox'] ? 'true' : 'false');

        log_activity('updated_settings', 'Updated Payment Gateway Settings');
        $this->toastSuccess('Payment gateway settings saved successfully.');
    }

    protected function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        $str = "\n" . $str . "\n";
        $envValue = trim($envValue);
        
        if (preg_match("/\n{$envKey}=(.*)/", $str)) {
            $str = preg_replace("/\n{$envKey}=.*/", "\n{$envKey}=\"{$envValue}\"", $str);
        } else {
            $str .= "{$envKey}=\"{$envValue}\"\n";
        }
        
        file_put_contents($envFile, trim($str) . "\n");
        
        try {
            Artisan::call('config:clear');
        } catch (\Exception $e) {}
    }

    public function render()
    {
        return view('livewire.admin.settings.payment-setting')->layout('layouts.app', ['title' => 'Payment Settings']);
    }
}

<?php

namespace App\Services;

use App\Support\SettingsStore;
use Illuminate\Support\Facades\Http;

class SSLCommerzService
{
    protected string $baseUrl;
    protected string $storeId;
    protected string $storePassword;

    public function __construct()
    {
        $settings = SettingsStore::group('payment');
        
        $isSandbox = $settings['sslcommerz_sandbox'] ?? true;
        $this->baseUrl = $isSandbox 
            ? 'https://sandbox.sslcommerz.com' 
            : 'https://securepay.sslcommerz.com';

        $this->storeId = $settings['sslcommerz_store_id'] ?? '';
        $this->storePassword = $settings['sslcommerz_store_password'] ?? '';
    }

    public function initPayment($data)
    {
        $response = Http::asForm()->post("{$this->baseUrl}/gwprocess/v4/api.php", array_merge($data, [
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
        ]));

        return $response->json();
    }

    public function validatePayment($valId)
    {
        $response = Http::get("{$this->baseUrl}/validator/api/validationserverAPI.php", [
            'val_id' => $valId,
            'store_id' => $this->storeId,
            'store_passwd' => $this->storePassword,
            'v' => 1,
            'format' => 'json'
        ]);

        return $response->json();
    }
}

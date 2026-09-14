<?php

namespace App\Services;

use App\Support\SettingsStore;
use Illuminate\Support\Facades\Http;

class BkashService
{
    protected string $baseUrl;
    protected string $appKey;
    protected string $appSecret;
    protected string $username;
    protected string $password;

    public function __construct()
    {
        $settings = SettingsStore::group('payment');
        
        $isSandbox = $settings['bkash_sandbox'] ?? true;
        $this->baseUrl = $isSandbox 
            ? 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout' 
            : 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized/checkout';

        $this->appKey = $settings['bkash_app_key'] ?? '';
        $this->appSecret = $settings['bkash_app_secret'] ?? '';
        $this->username = $settings['bkash_username'] ?? '';
        $this->password = $settings['bkash_password'] ?? '';
    }

    public function getGrantToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'password' => $this->password,
            'username' => $this->username,
        ])->post("{$this->baseUrl}/token/grant", [
            'app_key' => $this->appKey,
            'app_secret' => $this->appSecret,
        ]);

        return $response->json();
    }

    public function createPayment($idToken, $amount, $invoiceNumber, $callbackUrl)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $idToken,
            'X-APP-Key' => $this->appKey,
        ])->post("{$this->baseUrl}/create", [
            'mode' => '0011',
            'payerReference' => ' ',
            'callbackURL' => $callbackUrl,
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoiceNumber,
        ]);

        return $response->json();
    }

    public function executePayment($idToken, $paymentID)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $idToken,
            'X-APP-Key' => $this->appKey,
        ])->post("{$this->baseUrl}/execute", [
            'paymentID' => $paymentID,
        ]);

        return $response->json();
    }
}

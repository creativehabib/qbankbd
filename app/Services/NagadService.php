<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Support\SettingsStore;
use Carbon\Carbon;

class NagadService
{
    protected $merchantId;
    protected $merchantNumber;
    protected $publicKey;
    protected $privateKey;
    protected $baseUrl;
    protected $sandbox;

    public function __construct()
    {
        $settings = SettingsStore::group('payment');
        
        $this->merchantId = $settings['nagad_merchant_id'] ?? '';
        $this->merchantNumber = $settings['nagad_merchant_number'] ?? '';
        $this->publicKey = $this->formatKey($settings['nagad_public_key'] ?? '', 'public');
        $this->privateKey = $this->formatKey($settings['nagad_private_key'] ?? '', 'private');
        $this->sandbox = (bool) ($settings['nagad_sandbox'] ?? true);
        
        $this->baseUrl = $this->sandbox 
            ? 'http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs'
            : 'https://api.mynagad.com/api/dfs';
    }

    protected function formatKey($key, $type)
    {
        if (empty($key)) return '';
        
        // If it already has BEGIN headers, just ensure actual newlines and return
        if (str_contains($key, 'BEGIN ')) {
            $key = str_replace(["\r\n", "\r"], "\n", $key);
            return $key;
        }
        
        // Otherwise, assume it's a raw base64 string without headers
        $key = str_replace(["\n", "\r", " "], "", $key);
        $chunked = rtrim(chunk_split($key, 64, "\n"));
        
        if ($type === 'public') {
            return "-----BEGIN PUBLIC KEY-----\n" . $chunked . "\n-----END PUBLIC KEY-----";
        } else {
            return "-----BEGIN PRIVATE KEY-----\n" . $chunked . "\n-----END PRIVATE KEY-----";
        }
    }

    public function initializePayment($invoiceNumber, $amount)
    {
        $dateTime = Carbon::now()->timezone('Asia/Dhaka')->format('YmdHis');
        
        $sensitiveData = [
            'merchantId' => $this->merchantId,
            'datetime' => $dateTime,
            'orderId' => $invoiceNumber,
            'challenge' => $this->generateRandomString()
        ];
        
        $sensitiveDataJson = json_encode($sensitiveData);
        $encryptedSensitiveData = $this->encryptDataWithPublicKey($sensitiveDataJson);
        $signature = $this->signDataWithPrivateKey($sensitiveDataJson);

        $postData = [
            'dateTime' => $dateTime,
            'sensitiveData' => $encryptedSensitiveData,
            'signature' => $signature
        ];

        $initUrl = $this->baseUrl . '/check-out/initialize/' . $this->merchantId . '/' . $invoiceNumber;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-KM-IP-V4' => request()->ip(),
            'X-KM-Api-Version' => 'v-0.2.0',
            'X-KM-Client-Type' => 'PC_WEB'
        ])->post($initUrl, $postData);

        if ($response->successful() && isset($response['sensitiveData']) && isset($response['signature'])) {
            $decrypted = $this->decryptDataWithPrivateKey($response['sensitiveData']);
            $resSensitiveData = json_decode($decrypted, true);

            if (isset($resSensitiveData['paymentReferenceId'])) {
                // Step 2: Complete the checkout request
                return $this->completeCheckout($resSensitiveData['paymentReferenceId'], $invoiceNumber, $amount, $resSensitiveData['challenge'], $dateTime);
            }
        }

        return ['status' => 'error', 'message' => 'Nagad initialization failed. ' . $response->body()];
    }

    protected function completeCheckout($paymentReferenceId, $invoiceNumber, $amount, $challenge, $dateTime)
    {
        $sensitiveData = [
            'merchantId' => $this->merchantId,
            'orderId' => $invoiceNumber,
            'currencyCode' => '050', // BDT
            'amount' => number_format((float) $amount, 2, '.', ''),
            'challenge' => $challenge
        ];

        $sensitiveDataJson = json_encode($sensitiveData);
        $encryptedSensitiveData = $this->encryptDataWithPublicKey($sensitiveDataJson);
        $signature = $this->signDataWithPrivateKey($sensitiveDataJson);

        $postData = [
            'sensitiveData' => $encryptedSensitiveData,
            'signature' => $signature,
            'merchantCallbackURL' => route('payment.nagad.callback'),
            'additionalMerchantInfo' => [
                'packageName' => 'QBankBD Package'
            ]
        ];

        $completeUrl = $this->baseUrl . '/check-out/complete/' . $paymentReferenceId;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-KM-IP-V4' => request()->ip(),
            'X-KM-Api-Version' => 'v-0.2.0',
            'X-KM-Client-Type' => 'PC_WEB'
        ])->post($completeUrl, $postData);

        if ($response->successful() && isset($response['callBackUrl'])) {
            return [
                'status' => 'success', 
                'payment_url' => $response['callBackUrl'],
                'payment_ref_id' => $paymentReferenceId
            ];
        }

        return ['status' => 'error', 'message' => 'Nagad completion failed. ' . $response->body()];
    }

    public function verifyPayment($paymentRefId)
    {
        $verifyUrl = $this->baseUrl . '/verify/payment/' . $paymentRefId;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-KM-IP-V4' => request()->ip(),
            'X-KM-Api-Version' => 'v-0.2.0',
            'X-KM-Client-Type' => 'PC_WEB'
        ])->get($verifyUrl);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['status']) && $data['status'] === 'Success') {
                return ['status' => 'success', 'data' => $data];
            }
            return ['status' => 'failed', 'data' => $data];
        }

        return ['status' => 'error', 'message' => 'Nagad verification request failed.'];
    }

    protected function encryptDataWithPublicKey($data)
    {
        $keyResource = openssl_pkey_get_public($this->publicKey);
        
        if (!$keyResource) {
            // Try formatting as X.509 Certificate if regular public key format fails
            $cleanKey = str_replace(["-----BEGIN PUBLIC KEY-----\n", "\n-----END PUBLIC KEY-----", "-----BEGIN PUBLIC KEY-----", "-----END PUBLIC KEY-----"], "", $this->publicKey);
            $cert = "-----BEGIN CERTIFICATE-----\n" . trim($cleanKey) . "\n-----END CERTIFICATE-----";
            $keyResource = openssl_pkey_get_public($cert);
        }
        
        if (!$keyResource) {
            throw new \Exception('Nagad Public Key is invalid. Check API settings.');
        }
        
        if (!openssl_public_encrypt($data, $crypttext, $keyResource)) {
            throw new \Exception('Failed to encrypt data with Nagad Public Key.');
        }
        
        return base64_encode($crypttext);
    }

    protected function signDataWithPrivateKey($data)
    {
        $keyResource = openssl_pkey_get_private($this->privateKey);
        if (!$keyResource) {
            throw new \Exception('Nagad Private Key is invalid. Check API settings.');
        }
        
        if (!openssl_sign($data, $signature, $keyResource, OPENSSL_ALGO_SHA256)) {
            throw new \Exception('Failed to sign data with Nagad Private Key.');
        }
        
        return base64_encode($signature);
    }

    protected function decryptDataWithPrivateKey($crypttext)
    {
        $keyResource = openssl_pkey_get_private($this->privateKey);
        if (!$keyResource) {
            throw new \Exception('Nagad Private Key is invalid for decryption.');
        }
        
        openssl_private_decrypt(base64_decode($crypttext), $plainData, $keyResource);
        return $plainData;
    }

    protected function generateRandomString($length = 12)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

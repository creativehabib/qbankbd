<?php

use App\Livewire\Questions\BulkUpload;

it('throws a helpful error when google vision credentials are missing', function () {
    config()->set('services.google_vision.credentials', null);
    config()->set('services.google_vision.credentials_json', null);
    config()->set('services.google_vision.google_application_credentials', null);

    putenv('GOOGLE_APPLICATION_CREDENTIALS');

    $component = new BulkUpload();

    expect(fn () => (function (): void {
        $this->makeVisionClient();
    })->call($component))
        ->toThrow(RuntimeException::class, 'Google Vision credentials পাওয়া যায়নি');
});

it('rejects oauth client json for google vision', function () {
    config()->set('services.google_vision.credentials', null);
    config()->set('services.google_vision.google_application_credentials', null);
    config()->set('services.google_vision.credentials_json', json_encode([
        'type'          => 'authorized_user',
        'client_email'  => 'demo@example.com',
        'private_key'   => 'demo',
        'token_uri'     => 'https://oauth2.googleapis.com/token',
    ]));

    $component = new BulkUpload();

    expect(fn () => (function (): void {
        $this->makeVisionClient();
    })->call($component))
        ->toThrow(RuntimeException::class, 'Service Account JSON');
});

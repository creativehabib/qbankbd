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


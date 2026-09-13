<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Traits\InteractsWithFluxToasts;
use App\Support\SettingsStore;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Exception;

class EmailSetting extends Component
{
    use InteractsWithFluxToasts;

    public ?string $mail_mailer = 'smtp';
    public ?string $mail_host = '';
    public ?string $mail_port = '587';
    public ?string $mail_username = '';
    public ?string $mail_password = '';
    public ?string $mail_encryption = 'tls';
    public ?string $mail_from_address = '';
    public ?string $mail_from_name = '';

    public ?string $test_email_to = '';

    public function mount()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);
        
        $settings = SettingsStore::group('mail');
        
        $this->mail_mailer = $settings['mail_mailer'] ?? env('MAIL_MAILER', 'smtp');
        $this->mail_host = $settings['mail_host'] ?? env('MAIL_HOST', '');
        $this->mail_port = $settings['mail_port'] ?? env('MAIL_PORT', '587');
        $this->mail_username = $settings['mail_username'] ?? env('MAIL_USERNAME', '');
        $this->mail_password = $settings['mail_password'] ?? env('MAIL_PASSWORD', '');
        $this->mail_encryption = $settings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls');
        $this->mail_from_address = $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', '');
        $this->mail_from_name = $settings['mail_from_name'] ?? env('MAIL_FROM_NAME', '');
        
        $this->test_email_to = auth()->user()->email;
    }

    public function save()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $validated = $this->validate([
            'mail_mailer' => ['required', 'string'],
            'mail_host' => ['required', 'string'],
            'mail_port' => ['required', 'string'],
            'mail_username' => ['nullable', 'string'],
            'mail_password' => ['nullable', 'string'],
            'mail_encryption' => ['nullable', 'string'],
            'mail_from_address' => ['required', 'email'],
            'mail_from_name' => ['required', 'string'],
        ]);

        SettingsStore::saveGroup('mail', $validated);

        $this->toastSuccess('Email settings saved successfully.');
    }

    public function sendTestEmail()
    {
        abort_unless(auth()->user()?->hasRole(['admin', 'super_admin']), 403);

        $this->validate([
            'mail_from_address' => ['required', 'email'],
            'test_email_to' => ['required', 'email'],
        ]);
        
        // Dynamically configure mail for the test
        config([
            'mail.default' => $this->mail_mailer,
            'mail.mailers.smtp.host' => $this->mail_host,
            'mail.mailers.smtp.port' => $this->mail_port,
            'mail.mailers.smtp.username' => $this->mail_username,
            'mail.mailers.smtp.password' => $this->mail_password,
            'mail.mailers.smtp.encryption' => $this->mail_encryption,
            'mail.from.address' => $this->mail_from_address,
            'mail.from.name' => $this->mail_from_name,
        ]);

        try {
            Mail::raw('This is a test email from ' . config('app.name'), function ($message) {
                $message->to($this->test_email_to)
                    ->subject('Test Email - ' . config('app.name'));
            });

            $this->toastSuccess('Test email sent successfully to ' . $this->test_email_to);
        } catch (Exception $e) {
            $this->toastError('Failed to send email: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.email-setting')->layout('layouts.app', ['title' => 'Email Settings']);
    }
}

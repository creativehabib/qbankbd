<?php

namespace App\Providers;

use App\Support\ThemeTypography;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->shareThemeTypography();
        $this->configureDynamicSettings();
        $this->registerActivityLogListeners();
    }
    
    /**
     * Register listeners for automatic activity logging
     */
    protected function registerActivityLogListeners(): void
    {
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Login::class, function ($event) {
            log_activity('login', 'User logged into the system', $event->user->id);
        });
        
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Logout::class, function ($event) {
            if ($event->user) {
                log_activity('logout', 'User logged out of the system', $event->user->id);
            }
        });
        
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\Registered::class, function ($event) {
            log_activity('registered', 'New user registered', $event->user->id);
        });
        
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Auth\Events\PasswordReset::class, function ($event) {
            log_activity('password_reset', 'User reset their password', $event->user->id);
        });
    }

    /**
     * Override config with values from the database settings
     */
    protected function configureDynamicSettings(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $mailSettings = \App\Support\SettingsStore::group('mail');
                if (!empty($mailSettings['mail_mailer'])) {
                    config([
                        'mail.default' => $mailSettings['mail_mailer'],
                        'mail.mailers.smtp.host' => $mailSettings['mail_host'] ?? config('mail.mailers.smtp.host'),
                        'mail.mailers.smtp.port' => $mailSettings['mail_port'] ?? config('mail.mailers.smtp.port'),
                        'mail.mailers.smtp.username' => $mailSettings['mail_username'] ?? config('mail.mailers.smtp.username'),
                        'mail.mailers.smtp.password' => $mailSettings['mail_password'] ?? config('mail.mailers.smtp.password'),
                        'mail.mailers.smtp.encryption' => $mailSettings['mail_encryption'] ?? config('mail.mailers.smtp.encryption'),
                        'mail.from.address' => $mailSettings['mail_from_address'] ?? config('mail.from.address'),
                        'mail.from.name' => $mailSettings['mail_from_name'] ?? config('mail.from.name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Ignore during setup/migrations
        }
    }

    /**
     * Share theme typography settings with every view.
     */
    protected function shareThemeTypography(): void
    {
        View::share('themeTypography', ThemeTypography::current());
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}

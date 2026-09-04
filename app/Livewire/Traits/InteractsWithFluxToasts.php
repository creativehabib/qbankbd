<?php

namespace App\Livewire\Traits;

use Flux\Flux;

trait InteractsWithFluxToasts
{
    /**
     * Show a success toast notification
     */
    protected function toastSuccess(string $message, string $heading = 'Success'): void
    {
        Flux::toast(
            text: $message,
            heading: $heading,
            variant: 'success'
        );
    }

    /**
     * Show a warning toast notification
     */
    protected function toastWarning(string $message, string $heading = 'Warning'): void
    {
        Flux::toast(
            text: $message,
            heading: $heading,
            variant: 'warning'
        );
    }

    /**
     * Show a danger/error toast notification
     */
    protected function toastDanger(string $message, string $heading = 'Error'): void
    {
        Flux::toast(
            text: $message,
            heading: $heading,
            variant: 'danger'
        );
    }

    /**
     * (Optional) A generic toast method if you want to pass the variant dynamically
     */
    protected function toast(string $message, string $variant = 'success', ?string $heading = null): void
    {
        Flux::toast(
            text: $message,
            heading: $heading,
            variant: $variant
        );
    }
}

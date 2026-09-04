<?php

namespace App\Livewire\Traits;

use Flux\Flux;

trait InteractsWithFluxToasts
{
    protected function toastSuccess(string $message): void
    {
        Flux::toast($message);
    }
}

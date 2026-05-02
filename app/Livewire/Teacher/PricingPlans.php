<?php

namespace App\Livewire\Teacher;

use App\Models\Package;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PricingPlans extends Component
{
    public function render(): View
    {
        return view('livewire.teacher.pricing-plans', [
            'plans' => Package::query()->where('is_active', true)->orderBy('price')->get(),
        ]);
    }
}

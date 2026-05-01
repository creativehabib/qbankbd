<?php

namespace App\Livewire\Teacher;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class PricingPlans extends Component
{
    public function render(): View
    {
        return view('livewire.teacher.pricing-plans', [
            'plans' => [
                ['name' => 'Starter', 'price' => 3000, 'question_create' => 3000, 'page_view' => 'Unlimited', 'ad_free' => 'Unlimited'],
                ['name' => 'Growth', 'price' => 5000, 'question_create' => 6000, 'page_view' => 'Unlimited', 'ad_free' => 'Unlimited'],
                ['name' => 'Premium', 'price' => 9000, 'question_create' => 12000, 'page_view' => 'Unlimited', 'ad_free' => 'Unlimited'],
            ],
        ]);
    }
}

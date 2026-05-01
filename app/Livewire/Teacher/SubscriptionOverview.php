<?php

namespace App\Livewire\Teacher;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class SubscriptionOverview extends Component
{
    public function render(): View
    {
        return view('livewire.teacher.subscription-overview', [
            'subscription' => [
                'package_name' => 'Teacher Pro',
                'type' => 'Monthly',
                'validity' => '30 Days',
                'activity_limit' => 'Question Create 3000',
                'page_view' => 'Unlimited',
                'ad_free' => 'Unlimited',
            ],
        ]);
    }
}

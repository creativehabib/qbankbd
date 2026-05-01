<?php

namespace App\Livewire\Teacher;

use App\Models\UserSubscription;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class SubscriptionOverview extends Component
{
    public function render(): View
    {
        $subscription = UserSubscription::query()
            ->with('package')
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest('id')
            ->first();

        return view('livewire.teacher.subscription-overview', [
            'subscription' => $subscription,
        ]);
    }
}

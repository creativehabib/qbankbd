<?php

namespace App\Livewire\Students;

use App\Models\Package;
use App\Models\UserSubscription;
use Livewire\Component;
use App\Livewire\Traits\InteractsWithFluxToasts;

class CheckoutPage extends Component
{
    use InteractsWithFluxToasts;

    public Package $package;

    public function mount($package_id)
    {
        $this->package = Package::findOrFail($package_id);
    }

    public function render()
    {
        return view('livewire.students.checkout-page')->layout('layouts.app', ['title' => 'Checkout']);
    }
}

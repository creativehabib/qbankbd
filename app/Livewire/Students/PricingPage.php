<?php

namespace App\Livewire\Students;

use App\Models\Package;
use Livewire\Component;

class PricingPage extends Component
{
    public function render()
    {
        $subscriptions = Package::where('type', 'subscription')->where('is_active', true)->get();
        $courses = Package::where('type', 'course')->where('is_active', true)->get();

        return view('livewire.students.pricing-page', [
            'subscriptions' => $subscriptions,
            'courses' => $courses,
        ])->layout('layouts.app', ['title' => 'Premium Plans & Courses']);
    }
}

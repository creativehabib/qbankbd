<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class WebsiteTracking extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.website-tracking')->layout('layouts.app', ['title' => 'Website Tracking']);
    }
}

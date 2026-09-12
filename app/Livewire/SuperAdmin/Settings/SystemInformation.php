<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class SystemInformation extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.system-information')->layout('layouts.app', ['title' => 'System Information']);
    }
}

<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class ActivityLogs extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.activity-logs')->layout('layouts.app', ['title' => 'Activity Logs']);
    }
}

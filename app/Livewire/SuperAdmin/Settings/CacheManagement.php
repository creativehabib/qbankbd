<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class CacheManagement extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.cache-management')->layout('layouts.app', ['title' => 'Cache Management']);
    }
}

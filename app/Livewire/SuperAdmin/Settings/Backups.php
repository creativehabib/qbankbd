<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class Backups extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.backups')->layout('layouts.app', ['title' => 'Backups']);
    }
}

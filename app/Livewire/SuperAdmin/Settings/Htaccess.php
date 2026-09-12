<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class Htaccess extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.htaccess')->layout('layouts.app', ['title' => 'Htaccess']);
    }
}

<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class Index extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.index')->layout('layouts.app', ['title' => 'Settings']);
    }
}

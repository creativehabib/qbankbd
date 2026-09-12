<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class Languages extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.languages')->layout('layouts.app', ['title' => 'Languages']);
    }
}

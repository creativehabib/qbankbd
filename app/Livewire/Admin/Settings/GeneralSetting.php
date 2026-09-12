<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class GeneralSetting extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.general-setting')->layout('layouts.app', ['title' => 'General Setting']);
    }
}

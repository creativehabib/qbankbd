<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class EmailSetting extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.email-setting')->layout('layouts.app', ['title' => 'Email Setting']);
    }
}

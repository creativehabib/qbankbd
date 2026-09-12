<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;

class AiSetting extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.admin.settings.ai-setting')->layout('layouts.app', ['title' => 'Ai Setting']);
    }
}

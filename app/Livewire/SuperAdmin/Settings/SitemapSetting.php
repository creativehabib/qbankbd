<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;

class SitemapSetting extends Component
{
    public $perPage = 10;

    public function render()
    {
        return view('livewire.superadmin.settings.sitemap-setting')->layout('layouts.app', ['title' => 'Sitemap Setting']);
    }
}

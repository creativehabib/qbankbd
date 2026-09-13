<?php

namespace App\Livewire\SuperAdmin\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SystemInformation extends Component
{
    public function render()
    {
        abort_unless(auth()->user()?->hasRole('super_admin'), 403);

        $dbVersion = 'Unknown';
        try {
            $dbVersion = DB::select('select version() as version')[0]->version ?? 'Unknown';
        } catch (\Exception $e) {}

        $systemInfo = [
            'App Name' => config('app.name'),
            'App Environment' => config('app.env'),
            'App Debug Mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'App URL' => config('app.url'),
            'Laravel Version' => app()->version(),
            'PHP Version' => phpversion(),
            'Server OS' => php_uname('s') . ' ' . php_uname('r'),
            'Database Driver' => config('database.default'),
            'Database Version' => $dbVersion,
            'Memory Limit' => ini_get('memory_limit'),
            'Max Execution Time' => ini_get('max_execution_time') . ' seconds',
            'Upload Max Filesize' => ini_get('upload_max_filesize'),
            'Post Max Size' => ini_get('post_max_size'),
            'Timezone' => config('app.timezone'),
        ];

        return view('livewire.superadmin.settings.system-information', [
            'systemInfo' => $systemInfo
        ])->layout('layouts.app', ['title' => 'System Information']);
    }
}

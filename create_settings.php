<?php

$components = [
    'Admin/Settings/GeneralSetting' => 'admin.settings.general-setting',
    'Admin/Settings/EmailSetting' => 'admin.settings.email-setting',
    'Admin/Settings/AiSetting' => 'admin.settings.ai-setting',
    'Admin/Settings/Languages' => 'admin.settings.languages',
    'Admin/Settings/WebsiteTracking' => 'admin.settings.website-tracking',
    'SuperAdmin/Settings/SitemapSetting' => 'superadmin.settings.sitemap-setting',
    'SuperAdmin/Settings/Htaccess' => 'superadmin.settings.htaccess',
    'SuperAdmin/Settings/Backups' => 'superadmin.settings.backups',
    'SuperAdmin/Settings/CacheManagement' => 'superadmin.settings.cache-management',
    'SuperAdmin/Settings/SystemInformation' => 'superadmin.settings.system-information',
    'SuperAdmin/Settings/ActivityLogs' => 'superadmin.settings.activity-logs',
];

foreach ($components as $comp => $view_name) {
    $view_path = 'resources/views/livewire/'.str_replace('.', '/', $view_name).'.blade.php';
    $class_path = 'app/Livewire/'.$comp.'.php';

    if (! is_dir(dirname($view_path))) {
        mkdir(dirname($view_path), 0777, true);
    }
    if (! is_dir(dirname($class_path))) {
        mkdir(dirname($class_path), 0777, true);
    }

    $title = preg_replace('/(?<!^)([A-Z])/', ' \\1', basename($comp));

    file_put_contents($view_path, <<<VIEW
<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div>
        <flux:heading size="xl">$title</flux:heading>
        <flux:subheading>Manage settings.</flux:subheading>
    </div>
    <flux:card>
        <p class="text-zinc-500">Settings form will be implemented here.</p>
    </flux:card>
</div>
VIEW);

    $namespace = 'App\\Livewire\\'.str_replace('/', '\\', dirname($comp));
    $classname = basename($comp);

    file_put_contents($class_path, <<<CLASS
<?php

namespace $namespace;

use Livewire\Component;

class $classname extends Component
{
    public function render()
    {
        return view('livewire.$view_name')->layout('layouts.app', ['title' => '$title']);
    }
}
CLASS);
}
echo "Done!\n";

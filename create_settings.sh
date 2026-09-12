#!/bin/bash

declare -A components=(
    ["Admin/Settings/GeneralSetting"]="admin.settings.general"
    ["Admin/Settings/EmailSetting"]="admin.settings.email"
    ["Admin/Settings/AiSetting"]="admin.settings.ai"
    ["Admin/Settings/Languages"]="admin.settings.languages"
    ["Admin/Settings/WebsiteTracking"]="admin.settings.tracking"
    ["SuperAdmin/Settings/SitemapSetting"]="super-admin.settings.sitemap"
    ["SuperAdmin/Settings/Htaccess"]="super-admin.settings.htaccess"
    ["SuperAdmin/Settings/Backups"]="super-admin.settings.backups"
    ["SuperAdmin/Settings/CacheManagement"]="super-admin.settings.cache"
    ["SuperAdmin/Settings/SystemInformation"]="super-admin.settings.system-info"
    ["SuperAdmin/Settings/ActivityLogs"]="super-admin.settings.activity-logs"
)

for comp in "${!components[@]}"; do
    view_name="${components[$comp]}"
    view_path="resources/views/livewire/${view_name//./\/}.blade.php"
    class_path="app/Livewire/${comp}.php"
    
    mkdir -p "$(dirname "$view_path")"
    mkdir -p "$(dirname "$class_path")"
    
    # Create View
    cat << VIEW > "$view_path"
<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div>
        <flux:heading size="xl">$(basename "$comp" | sed 's/\([A-Z]\)/ \1/g' | xargs)</flux:heading>
        <flux:subheading>Manage settings.</flux:subheading>
    </div>
    <flux:card>
        <p class="text-zinc-500">Settings form will be implemented here.</p>
    </flux:card>
</div>
VIEW

    # Create Class
    namespace="App\\Livewire\\$(dirname "$comp" | tr '/' '\\')"
    classname="$(basename "$comp")"
    
    cat << CLASS > "$class_path"
<?php

namespace $namespace;

use Livewire\Component;

class $classname extends Component
{
    public function render()
    {
        return view('livewire.$view_name')->layout('layouts.app', ['title' => '$classname']);
    }
}
CLASS

done

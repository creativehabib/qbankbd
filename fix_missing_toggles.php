<?php

$files = [
    'resources/views/livewire/topics/topic-index.blade.php' => ['var' => 'topic', 'active' => 'is_active', 'premium' => 'is_premium'],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['var' => 'examCategory', 'active' => 'is_active', 'premium' => 'is_premium'],
    'resources/views/livewire/admin/tags/index.blade.php' => ['var' => 'tag', 'active' => 'is_active', 'premium' => false],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);

    $var = $config['var'];

    if (! str_contains($content, 'toggleAction=')) {
        if ($config['active']) {
            $activeField = $config['active'];
            $premiumField = $config['premium'];

            $props = 'deleteAction="delete({{ $'.$var."->id }})\"\n                    :statusBadge=\"\$".$var.'->'.$activeField." ? 'Active' : null\"\n                    toggleAction=\"toggleActive({{ \$".$var."->id }})\"\n                    :toggleState=\"\$".$var.'->'.$activeField.'"';

            $content = preg_replace('/deleteAction="delete\(\{\{ \$'.$var.'->id \}\}\)"/', $props, $content);

            if ($premiumField && ! str_contains($content, '<x-slot:end>')) {
                $endSlot = "                    <x-slot:end>\n                        {{ \$".$var.'->'.$premiumField." ? 'Premium' : 'Standard' }}\n                    </x-slot:end>";
                $content = preg_replace('/<\/x-modern-list-item>/', $endSlot."\n                </x-modern-list-item>", $content);
            }
        }
        file_put_contents($file, $content);
        echo "Added toggleAction to $file\n";
    }
}

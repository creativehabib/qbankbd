<?php

$files = [
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['var' => 'chapter', 'active' => 'is_active', 'premium' => 'is_premium'],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['var' => 'academicClass', 'active' => 'class_is_active', 'premium' => 'class_is_premium'],
    'resources/views/livewire/topics/topic-index.blade.php' => ['var' => 'topic', 'active' => false, 'premium' => false],
    'resources/views/livewire/exam-categories/exam-categories-index.blade.php' => ['var' => 'examCategory', 'active' => false, 'premium' => false],
    'resources/views/livewire/admin/tags/index.blade.php' => ['var' => 'tag', 'active' => false, 'premium' => false],
];

foreach ($files as $file => $config) {
    if (! file_exists($file)) {
        continue;
    }
    $content = file_get_contents($file);
    $var = $config['var'];

    // Fix broken $
    $content = preg_replace('/deleteAction="delete\(\{\{ \$ \}\}\)".*?:toggleState="\$"/s', 'deleteAction="delete({{ $'.$var.'->id }})"', $content);

    if ($config['active']) {
        $activeField = $config['active'];
        $premiumField = $config['premium'];

        $props = 'deleteAction="delete({{ $'.$var."->id }})\"\n                    :statusBadge=\"\$".$var.'->'.$activeField." ? 'Active' : null\"\n                    toggleAction=\"toggleActive({{ \$".$var."->id }})\"\n                    :toggleState=\"\$".$var.'->'.$activeField.'"';

        $content = preg_replace('/deleteAction="delete\(\{\{ \$'.$var.'->id \}\}\)"/', $props, $content);

        // Remove empty lines
        $content = preg_replace('/^\s*$/m', '', $content);

        // Ensure proper end slot
        if (! str_contains($content, '<x-slot:end>')) {
            $endSlot = "                    <x-slot:end>\n                        {{ \$".$var.'->'.$premiumField." ? 'Premium' : 'Standard' }}\n                    </x-slot:end>";
            $content = preg_replace('/<\/x-modern-list-item>/', $endSlot."\n                </x-modern-list-item>", $content);
        }
    }
    file_put_contents($file, $content);
}

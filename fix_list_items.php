<?php

$files = [
    'resources/views/livewire/chapters/chapter-index.blade.php' => ['var' => 'chapter', 'active' => true, 'premium' => true],
    'resources/views/livewire/academic-classes/class-index.blade.php' => ['var' => 'class', 'active' => true, 'premium' => true],
    'resources/views/livewire/subjects/subject-index.blade.php' => ['var' => 'subject', 'active' => true, 'premium' => true],
];

foreach ($files as $file => $config) {
    $content = file_get_contents($file);
    $var = $config['var'];

    // Class-index uses class_is_active and class_is_premium
    $activeField = ($var === 'class') ? 'class_is_active' : 'is_active';
    $premiumField = ($var === 'class') ? 'class_is_premium' : 'is_premium';

    $props = 'deleteAction="delete({{ $'.$var."->id }})\"\n                    :statusBadge=\"\$".$var.'->'.$activeField." ? 'Active' : null\"\n                    toggleAction=\"toggleActive({{ \$".$var."->id }})\"\n                    :toggleState=\"\$".$var.'->'.$activeField.'"';

    // Replace deleteAction and old props
    $content = preg_replace('/deleteAction="delete\(\{\{ \$'.$var.'->id \}\}\)".*?:toggleState="[^"]+"/s', 'deleteAction="delete({{ $'.$var.'->id }})"', $content);
    $content = preg_replace('/deleteAction="delete\(\{\{ \$'.$var.'->id \}\}\)"/', $props, $content);

    // Remove the old badges slot and end slot entirely to reset
    $content = preg_replace('/<x-slot:badges>.*?<\/x-slot:badges>/s', '', $content);
    $content = preg_replace('/<x-slot:end>.*?<\/x-slot:end>/s', '', $content);

    $endSlot = "                    <x-slot:end>\n                        {{ \$".$var.'->'.$premiumField." ? 'Premium' : 'Standard' }}\n                    </x-slot:end>";
    $content = preg_replace('/<\/x-modern-list-item>/', $endSlot."\n                </x-modern-list-item>", $content);

    file_put_contents($file, $content);
    echo "Updated items in $file\n";
}

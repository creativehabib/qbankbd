<?php

$file = 'resources/views/livewire/academic-classes/class-index.blade.php';
$content = file_get_contents($file);

// Add pagination links at the end of the table slot
if (! str_contains($content, '->links(')) {
    $content = preg_replace('/<\/x-modern-list>\s*<\/x-slot:table>/', "</x-modern-list>\n\n        @if(method_exists(\$academicClasses, 'hasPages') && \$academicClasses->hasPages())\n            {{ \$academicClasses->links('components.modern-pagination') }}\n        @endif\n    </x-slot:table>", $content);
}

// Fix $class undefined variable in class_is_premium
$content = str_replace('$class->class_is_premium', '$academicClass->class_is_premium', $content);
$content = str_replace('deleteAction="deleteClass({{ $academicClass->id }})"', 'deleteAction="deleteClass({{ $academicClass->id }})" toggleAction="toggleActive({{ $academicClass->id }})" :toggleState="$academicClass->class_is_active"', $content);

file_put_contents($file, $content);

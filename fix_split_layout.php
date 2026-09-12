<?php

$file = 'resources/views/components/split-layout.blade.php';
$content = file_get_contents($file);

if (! str_contains($content, '{{ $slot }}')) {
    $content = str_replace('</div>', "{{ \$slot }}\n</div>", $content);
    // Actually that will put it inside the inner div? Let's be precise.
    $content = preg_replace('/<\/div>\s*$/', "    {{ \$slot }}\n</div>", $content);
    file_put_contents($file, $content);
}

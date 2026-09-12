<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$script = <<<'BLADE'

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('default-theme-updated', (event) => {
            // When admin changes the default theme, clear their personal preference 
            // so they can actually see the new default theme they just set.
            window.localStorage.removeItem('flux.appearance');
            window.localStorage.removeItem('theme');
            
            if (window.Flux && window.Flux.applyAppearance) {
                window.Flux.applyAppearance(event[0].theme, false);
            }
        });
    });
</script>
BLADE;

$content .= $script;
file_put_contents($file, $content);

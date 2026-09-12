<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
        Livewire.on('default-theme-updated', (event) => {
            // When admin changes the default theme, clear their personal preference 
            // so they can actually see the new default theme they just set.
            window.localStorage.removeItem('flux.appearance');
            window.localStorage.removeItem('theme');
            
            if (window.Flux && window.Flux.applyAppearance) {
                window.Flux.applyAppearance(event[0].theme, false);
            }
        });
BLADE;

$replace = <<<'BLADE'
        Livewire.on('default-theme-updated', (event) => {
            // Livewire 3 passes arguments as an array if not named, or object if named.
            // But sometimes it wraps in an array. Let's handle both.
            let theme = event.theme || (event[0] && event[0].theme) || (event[0] ? event[0] : null);
            
            if (!theme) return;
            
            window.localStorage.removeItem('flux.appearance');
            window.localStorage.removeItem('theme');
            
            if (window.Flux && window.Flux.applyAppearance) {
                window.Flux.applyAppearance(theme, false);
            }
        });
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

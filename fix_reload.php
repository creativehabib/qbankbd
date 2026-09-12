<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
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

// We will just listen to branding-saved instead and do a full reload,
// but before reloading, we can clear the theme if needed, or better,
// just let the backend handle it!
// Actually, wait, if they change the default theme, we want to clear their local storage so they see it!

$replace = <<<'BLADE'
        Livewire.on('default-theme-updated', (event) => {
            let theme = event.theme || (event[0] && event[0].theme) || (event[0] ? event[0] : null);
            
            if (theme) {
                window.localStorage.removeItem('flux.appearance');
                window.localStorage.removeItem('theme');
            }
        });

        Livewire.on('branding-saved', () => {
            // Reload the page so that CSS variables in <head> and new logos are applied instantly
            setTimeout(() => {
                window.location.reload();
            }, 500); // 500ms delay to allow the success toast (if any) to appear, though flux toast usually persists or we can just reload immediately.
        });
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

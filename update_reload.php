<?php

$file = 'resources/views/livewire/admin/settings/branding-theme.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
        Livewire.on('branding-saved', () => {
            // Reload the page so that CSS variables in <head> and new logos are applied instantly
            setTimeout(() => {
                window.location.reload();
            }, 500); // 500ms delay to allow the success toast (if any) to appear, though flux toast usually persists or we can just reload immediately.
        });
BLADE;

$replace = <<<'BLADE'
        Livewire.on('branding-saved', () => {
            if (typeof Flux !== 'undefined' && typeof Flux.toast === 'function') {
                Flux.toast({
                    title: 'Settings saved',
                    description: 'Applying new branding theme...',
                    variant: 'success'
                });
            }
            // Reload the page so that CSS variables in <head> and new logos are applied instantly
            setTimeout(() => {
                window.location.reload();
            }, 800); 
        });
BLADE;

$content = str_replace($search, $replace, $content);
file_put_contents($file, $content);

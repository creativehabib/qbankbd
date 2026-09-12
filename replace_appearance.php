<?php

$file = 'resources/views/partials/head.blade.php';
$content = file_get_contents($file);

// Extract default theme in PHP block
$searchPhp = <<<'PHP'
    $accentColor = $branding['accent_color'] ?? '#3b82f6';
    $textColor = $branding['text_color'] ?? '#ffffff';
PHP;
$replacePhp = <<<'PHP'
    $accentColor = $branding['accent_color'] ?? '#3b82f6';
    $textColor = $branding['text_color'] ?? '#ffffff';
    $defaultTheme = $branding['default_theme'] ?? 'System';
PHP;

if (! str_contains($content, '$defaultTheme =')) {
    $content = str_replace($searchPhp, $replacePhp, $content);
}

// Replace @fluxAppearance
$searchFlux = '@fluxAppearance';

$replaceFlux = <<<'BLADE'
<style>
    :root.dark {
        color-scheme: dark;
    }
</style>
<script>
    window.Flux = {
        applyAppearance (appearance) {
            let applyDark = () => document.documentElement.classList.add('dark')
            let applyLight = () => document.documentElement.classList.remove('dark')

            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')

                window.localStorage.removeItem('flux.appearance')

                media.matches ? applyDark() : applyLight()
            } else if (appearance === 'dark') {
                window.localStorage.setItem('flux.appearance', 'dark')

                applyDark()
            } else if (appearance === 'light') {
                window.localStorage.setItem('flux.appearance', 'light')

                applyLight()
            }
        }
    }

    window.Flux.applyAppearance(window.localStorage.getItem('flux.appearance') || '{{ strtolower($defaultTheme) }}')
</script>
BLADE;

$content = str_replace($searchFlux, $replaceFlux, $content);

file_put_contents($file, $content);

<?php

$file = 'resources/views/partials/head.blade.php';
$content = file_get_contents($file);

$search = <<<'BLADE'
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
BLADE;

$replace = <<<'BLADE'
        applyAppearance (appearance, saveToStorage = true) {
            let applyDark = () => document.documentElement.classList.add('dark')
            let applyLight = () => document.documentElement.classList.remove('dark')

            if (appearance === 'system') {
                let media = window.matchMedia('(prefers-color-scheme: dark)')

                if (saveToStorage) window.localStorage.removeItem('flux.appearance')

                media.matches ? applyDark() : applyLight()
            } else if (appearance === 'dark') {
                if (saveToStorage) window.localStorage.setItem('flux.appearance', 'dark')

                applyDark()
            } else if (appearance === 'light') {
                if (saveToStorage) window.localStorage.setItem('flux.appearance', 'light')

                applyLight()
            }
        }
    }

    const userPref = window.localStorage.getItem('flux.appearance') || window.localStorage.getItem('theme');
    const adminDefault = '{{ strtolower($defaultTheme) }}';

    if (userPref) {
        window.Flux.applyAppearance(userPref, false);
    } else {
        window.Flux.applyAppearance(adminDefault, false);
    }
BLADE;

$content = str_replace($search, $replace, $content);

file_put_contents($file, $content);

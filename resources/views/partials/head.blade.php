<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $branding = \App\Support\SettingsStore::group('branding');
    $appName = $branding['app_name'] ?? config('app.name', 'Question Bank');
    $favicon = $branding['favicon'] ? \Illuminate\Support\Str::startsWith($branding['favicon'], ['http://', 'https://']) ? $branding['favicon'] : asset('storage/'.$branding['favicon']) : '/favicon.ico';
    $accentColor = $branding['accent_color'] ?? '#3b82f6';
    $textColor = $branding['text_color'] ?? '#ffffff';
    $defaultTheme = $branding['default_theme'] ?? 'System';
@endphp

<title>
    {{ filled($title ?? null) ? $title.' - '.$appName : $appName }}
</title>

<link rel="icon" href="{{ $favicon }}" sizes="any">
<link rel="apple-touch-icon" href="{{ $favicon }}">

<style>
    :root, .dark {
        --color-accent: {{ $accentColor }};
        --color-accent-content: {{ $accentColor }};
        --color-accent-foreground: {{ $textColor }};
        
        --app-dark-active-bg: color-mix(in srgb, var(--color-accent) 15%, transparent);
        --app-dark-active-text: var(--color-accent);
        --app-dark-border: color-mix(in srgb, var(--color-accent) 20%, transparent);
    }
</style>

@if($primaryFont = setting('primary_font'))
    @php
        $primaryFont = trim($primaryFont);
        $primaryFontWeights = trim((string) setting('primary_font_weights', '300;400;500;600;700'));
        $googleFontHref = null;

        if ($primaryFont !== '') {
            $googleFontHref = 'https://fonts.googleapis.com/css2?family='.urlencode($primaryFont).':wght@'.$primaryFontWeights.'&display=swap';
        }
    @endphp

    @if($googleFontHref)
        <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="dns-prefetch" href="https://fonts.googleapis.com">
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link rel="preload" as="style" href="{{ $googleFontHref }}" fetchpriority="high">
        <link href="{{ $googleFontHref }}" rel="stylesheet" media="print" onload="this.media='all'">
        <noscript><link href="{{ $googleFontHref }}" rel="stylesheet"></noscript>
    @endif

    <style>
        :root { --font-sans: "{{ $primaryFont }}", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    </style>
@endif
@if($bodyFontSize = setting('body_font_size'))
    <style>
        :root { --body-font-size: {{ trim($bodyFontSize) }}; }
        body { font-size: var(--body-font-size); }
    </style>
@endif

<script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
    window.MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']],
            processEscapes: true,
        },
        options: {
            // এটি দিলে নির্দিষ্ট ক্লাসের প্রয়োজন হবে না, সব জায়গাই স্ক্যান করবে
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
            // তবে আপনি যদি নির্দিষ্ট ক্লাস ব্যবহার করতে চান, তবে নিচের ২টি লাইন রাখতে পারেন
            ignoreHtmlClass: 'tex2jax_ignore',
            processHtmlClass: 'tex2jax_process'
        },
    };
</script>
<script defer id="mathjax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('styles')
<style>
    :root.dark {
        color-scheme: dark;
    }
</style>
<script>
    window.Flux = {
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
</script>

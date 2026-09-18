<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $branding = \App\Support\SettingsStore::group('branding');
    $general = \App\Support\SettingsStore::group('general');
    $appName = $branding['app_name'] ?? config('app.name', 'Question Bank');
    $siteDesc = $general['site_description'] ?? 'বাংলাদেশের সেরা ডিজিটাল প্রশ্নভান্ডার ও অনলাইন লার্নিং প্ল্যাটফর্ম।';
    $favicon = !empty($branding['favicon']) ? (\Illuminate\Support\Str::startsWith($branding['favicon'], ['http://', 'https://']) ? $branding['favicon'] : asset('storage/'.$branding['favicon'])) : asset('images/favicon.png');
    
    // SEO Meta Tags Dynamic Setup
    $ogImage = !empty($branding['logo_dark']) ? (\Illuminate\Support\Str::startsWith($branding['logo_dark'], ['http://', 'https://']) ? $branding['logo_dark'] : asset('storage/'.$branding['logo_dark'])) : asset('images/og-image.png');
    $pageTitle = filled($title ?? null) ? $title.' - '.$appName : $appName;
    $pageDesc = filled($description ?? null) ? $description : $siteDesc;
    $currentUrl = url()->current();

    $accentColor = $branding['accent_color'] ?? '#3b82f6';
    $textColor = $branding['text_color'] ?? '#ffffff';
    $darkBgColor = $branding['dark_bg_color'] ?? '#18181b';
    $defaultTheme = $branding['default_theme'] ?? 'System';
    
    $tracking = \App\Support\SettingsStore::group('tracking');
@endphp

<title>{{ $pageTitle }}</title>
<meta name="title" content="{{ $pageTitle }}">
<meta name="description" content="{{ $pageDesc }}">
<meta name="author" content="{{ $appName }}">
<meta name="robots" content="index, follow">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDesc }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:site_name" content="{{ $appName }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ $currentUrl }}">
<meta property="twitter:title" content="{{ $pageTitle }}">
<meta property="twitter:description" content="{{ $pageDesc }}">
<meta property="twitter:image" content="{{ $ogImage }}">

@if(!empty($tracking['google_analytics_id']))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $tracking['google_analytics_id'] }}"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '{{ $tracking['google_analytics_id'] }}');
    </script>
@endif

@if(!empty($tracking['facebook_pixel_id']))
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $tracking['facebook_pixel_id'] }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $tracking['facebook_pixel_id'] }}&ev=PageView&noscript=1"
    /></noscript>
@endif

@if(!empty($tracking['custom_header_script']))
    {!! $tracking['custom_header_script'] !!}
@endif

<link rel="icon" href="{{ $favicon }}" sizes="any">
<link rel="apple-touch-icon" href="{{ $favicon }}">

<style>
    :root, .dark {
        --color-accent: {{ $accentColor }};
        --color-accent-content: {{ $accentColor }};
        --color-accent-foreground: {{ $textColor }};
        
        --color-emerald-50: color-mix(in oklab, {{ $accentColor }} 10%, white);
        --color-emerald-100: color-mix(in oklab, {{ $accentColor }} 20%, white);
        --color-emerald-200: color-mix(in oklab, {{ $accentColor }} 40%, white);
        --color-emerald-300: color-mix(in oklab, {{ $accentColor }} 60%, white);
        --color-emerald-400: color-mix(in oklab, {{ $accentColor }} 80%, white);
        --color-emerald-500: {{ $accentColor }};
        --color-emerald-600: color-mix(in oklab, {{ $accentColor }} 85%, black);
        --color-emerald-700: color-mix(in oklab, {{ $accentColor }} 70%, black);
        --color-emerald-800: color-mix(in oklab, {{ $accentColor }} 55%, black);
        --color-emerald-900: color-mix(in oklab, {{ $accentColor }} 40%, black);
        --color-emerald-950: color-mix(in oklab, {{ $accentColor }} 25%, black);

        --color-indigo-50: color-mix(in oklab, {{ $accentColor }} 10%, white);
        --color-indigo-100: color-mix(in oklab, {{ $accentColor }} 20%, white);
        --color-indigo-200: color-mix(in oklab, {{ $accentColor }} 40%, white);
        --color-indigo-300: color-mix(in oklab, {{ $accentColor }} 60%, white);
        --color-indigo-400: color-mix(in oklab, {{ $accentColor }} 80%, white);
        --color-indigo-500: {{ $accentColor }};
        --color-indigo-600: color-mix(in oklab, {{ $accentColor }} 85%, black);
        --color-indigo-700: color-mix(in oklab, {{ $accentColor }} 70%, black);
        --color-indigo-800: color-mix(in oklab, {{ $accentColor }} 55%, black);
        --color-indigo-900: color-mix(in oklab, {{ $accentColor }} 40%, black);
        --color-indigo-950: color-mix(in oklab, {{ $accentColor }} 25%, black);
        
        --app-dark-active-bg: color-mix(in srgb, var(--color-accent) 15%, transparent);
        --app-dark-active-text: var(--color-accent);
        --app-dark-border: color-mix(in srgb, var(--color-accent) 20%, transparent);
    }
    
        html.dark {
        --color-zinc-950: color-mix(in oklab, {{ $darkBgColor }} 50%, #020617);
        --color-zinc-900: color-mix(in oklab, {{ $darkBgColor }} 15%, #0f172a);
        --color-zinc-800: color-mix(in oklab, {{ $darkBgColor }} 5%, #1e293b);
        --color-zinc-700: #334155;
        --color-zinc-600: #475569;
        --color-zinc-500: #64748b;
        --color-zinc-400: #94a3b8;
        --color-zinc-300: #cbd5e1;
        --color-zinc-200: #e2e8f0;
        --color-zinc-100: #f1f5f9;
        --color-zinc-50:  #f8fafc;
    }
    html.dark body {
        background-color: var(--color-zinc-950);
    }
    html.dark .header-dynamic-bg {
        background-color: color-mix(in srgb, var(--color-zinc-900) 85%, transparent);
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
        :root { --body-font-size: {{ trim($bodyFontSize)  }
        body { font-size: var(--body-font-size); }
    </style>
@endif

<script src="/ckeditor/ckeditor.js" type="text/javascript"></script>

<script>
    document.addEventListener('livewire:navigated', () => {
        if (typeof window.renderKatex === 'function') {
            window.renderKatex();
        }
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('commit', ({ succeed }) => {
            succeed(() => {
                requestAnimationFrame(() => {
                    if (typeof window.renderKatex === 'function') {
                        window.renderKatex();
                    }
                });
            });
        });
    });
</script>
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

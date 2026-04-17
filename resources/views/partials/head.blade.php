<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@if(filled($themeTypography['google_fonts_url'] ?? null))
    <link href="{{ $themeTypography['google_fonts_url'] }}" rel="stylesheet" />
@endif

<style>
    :root {
        --font-sans: {!! $themeTypography['css_font_family'] ?? "'Instrument Sans', ui-sans-serif, system-ui, sans-serif" !!};
        --app-body-font-size: {{ $themeTypography['body_font_size'] ?? '16px' }};
    }

    body {
        font-size: var(--app-body-font-size);
    }
</style>

<script src="/ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
    window.MathJax = {
        tex: {
            inlineMath: [['$', '$'], ['\\(', '\\)']],
            displayMath: [['$$', '$$'], ['\\[', '\\]']],
            processEscapes: true,
        },
        options: {
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
        },
    };
</script>
<script defer id="mathjax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('scripts')
@fluxAppearance

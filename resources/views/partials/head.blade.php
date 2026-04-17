<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

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
            skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre', 'code'],
        },
    };
</script>
<script defer id="mathjax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('scripts')
@fluxAppearance

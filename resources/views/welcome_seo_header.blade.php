@php
    $generalSettings = \App\Support\SettingsStore::group('general');
    $brandingSettings = \App\Support\SettingsStore::group('branding');
    $trackingSettings = \App\Support\SettingsStore::group('tracking');
    
    $siteName = $brandingSettings['app_name'] ?? 'প্রশ্নব্যাংক';
    $siteDesc = $generalSettings['site_description'] ?? 'বাংলাদেশের সেরা ডিজিটাল প্রশ্নভান্ডার ও অনলাইন লার্নিং প্ল্যাটফর্ম। বিভিন্ন প্রতিযোগিতামূলক পরীক্ষার প্রস্তুতি নিতে আজই যুক্ত হোন।';
    $faviconUrl = filled($brandingSettings['favicon'] ?? null) ? asset('storage/' . $brandingSettings['favicon']) : asset('images/favicon.png');
    $ogImage = filled($brandingSettings['logo_dark'] ?? null) ? asset('storage/' . $brandingSettings['logo_dark']) : asset('images/og-image.png');
    $appUrl = config('app.url');
    $pageTitle = $siteName . ' - ' . 'বাংলাদেশের সেরা ডিজিটাল প্রশ্নভান্ডার';
    
    $fbUrl = $generalSettings['facebook_url'] ?? '';
    $headerScript = $trackingSettings['custom_header_script'] ?? '';
@endphp
<!DOCTYPE html>
<html lang="bn" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $siteDesc }}">
    <meta name="author" content="{{ $siteName }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $appUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $siteDesc }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    @if(filled($fbUrl))
    <meta property="article:publisher" content="{{ $fbUrl }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $appUrl }}">
    <meta property="twitter:title" content="{{ $pageTitle }}">
    <meta property="twitter:description" content="{{ $siteDesc }}">
    <meta property="twitter:image" content="{{ $ogImage }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ $faviconUrl }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Tiro+Bangla:wght@400;700&display=swap" rel="stylesheet">

    <!-- Custom Header Scripts (e.g. Analytics, Pixel) -->
    @if(filled($headerScript))
        {!! $headerScript !!}
    @endif

<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    <script>window.manuallyStartAlpine = true;</script>
    <title>@yield('title', 'ডিফল্ট সাইট টাইটেল')</title>
    <meta name="description" content="@yield('description', 'ডিফল্ট সাইট ডিসক্রিপশন')">

    @include('frontend.partials.head')

    <style>
        body, html {
            -webkit-user-select: none;
            user-select: none;
        }
        /* Hide scrollbar for clean app-like drawer */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body.math-loading [data-math-content], body.math-loading {
            visibility: hidden;
        }
    </style>

    @stack('style')
</head>
<body class="math-loading bg-slate-50 text-slate-800 dark:text-slate-200 font-sans antialiased min-h-screen flex flex-col pb-20 lg:pb-0 transition-colors duration-300">

    @include('frontend.header')

    <!-- Main Content Area -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @include('frontend.bottom-nav')

    @include('frontend.mobile-drawer')

    @include('frontend.scripts')
    @include('frontend.search-modal')
    <!-- Sitewide Content Protection & Anti-Inspection Shield -->
    <script>
        window.__SECURITY_CONFIG__ = {
            disableRightClick: false, // রাইট ক্লিক বন্ধ করতে চাইলে true দিন
            disableTextCopy: true,    // টেক্সট কপি করা বন্ধ করতে true দিন (বর্তমানে চালু আছে)
            disableInspect: false,    // Inspect/Developer Tools বন্ধ করতে চাইলে true দিন

            // লারাভেল থেকে ডাইনামিকভাবে চেক করা হচ্ছে ইউজার অ্যাডমিন কিনা
            // অ্যাডমিন হলে এই রেস্ট্রিকশনগুলো কাজ করবে না
            isAdmin: @json(auth()->check() && auth()->user()->role === 'admin')
        };
    </script>
    <script src="{{ asset('/security-shield.js') }}" defer></script>
    @stack('script')
</body>
</html>

<!DOCTYPE html>
<html lang="bn" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>প্রশ্নব্যাংক - বাংলাদেশের সেরা ডিজিটাল প্রশ্নভান্ডার</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&family=Tiro+Bangla:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
        }

        .font-tiro {
            font-family: 'Tiro Bangla', serif;
        }

        .noise-overlay {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
        }
    </style>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('qb-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const shouldUseDark = savedTheme ? savedTheme === 'dark' : prefersDark;

            if (shouldUseDark) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#f5f3ee] text-slate-900 transition-colors duration-300 dark:bg-[#0d0f1a] dark:text-slate-100">
<header class="fixed inset-x-0 top-0 z-50 border-b border-sky-200/50 bg-[#f5f3ee]/90 backdrop-blur-lg dark:border-sky-700/30 dark:bg-[#0d0f1a]/90">
    <nav class="mx-auto flex h-17 w-full max-w-7xl items-center justify-between px-4 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-sky-600 dark:text-sky-400">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-sky-600 text-sm font-bold text-white">প্র</span>
            <span class="font-tiro text-xl font-bold">প্রশ্নব্যাংক</span>
        </a>

        <ul class="hidden items-center gap-7 text-sm font-medium text-slate-600 dark:text-slate-300 md:flex">
            <li><a href="#features" class="transition hover:text-sky-600">ফিচারসমূহ</a></li>
            <li><a href="#howto" class="transition hover:text-sky-600">কিভাবে কাজ করে</a></li>
            <li><a href="#pricing" class="transition hover:text-sky-600">মূল্য তালিকা</a></li>
            <li><a href="#faq" class="transition hover:text-sky-600">সাধারণ জিজ্ঞাসা</a></li>
        </ul>

        <div class="flex items-center gap-3">
            <button id="theme-toggle" type="button" class="inline-flex h-9 w-15 items-center rounded-full border border-sky-200 bg-white px-1.5 transition dark:border-sky-700 dark:bg-slate-900" aria-label="Toggle theme">
                <span id="theme-knob" class="h-6 w-6 rounded-full bg-sky-500 transition-transform duration-300"></span>
            </button>
            @if (Route::has('login'))
                <a href="{{ route('login') }}" class="hidden rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-sky-600/30 transition hover:bg-sky-700 sm:inline-flex">শুরু করুন</a>
            @endif
            <button id="menu-toggle" type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-sky-200 text-slate-700 dark:border-sky-700 dark:text-slate-200 md:hidden">☰</button>
        </div>
    </nav>
    <div id="mobile-menu" class="hidden border-t border-sky-200/60 bg-[#f5f3ee] px-4 py-3 dark:border-sky-700/40 dark:bg-[#0d0f1a] md:hidden">
        <ul class="space-y-2 text-sm font-medium text-slate-600 dark:text-slate-300">
            <li><a href="#features" class="block rounded-md px-2 py-1 hover:bg-sky-100 dark:hover:bg-slate-800">ফিচারসমূহ</a></li>
            <li><a href="#howto" class="block rounded-md px-2 py-1 hover:bg-sky-100 dark:hover:bg-slate-800">কিভাবে কাজ করে</a></li>
            <li><a href="#pricing" class="block rounded-md px-2 py-1 hover:bg-sky-100 dark:hover:bg-slate-800">মূল্য তালিকা</a></li>
            <li><a href="#faq" class="block rounded-md px-2 py-1 hover:bg-sky-100 dark:hover:bg-slate-800">সাধারণ জিজ্ঞাসা</a></li>
        </ul>
    </div>
</header>

<main class="pt-17">
    <section class="relative overflow-hidden bg-[linear-gradient(135deg,#e0f2fe_0%,#f5f3ee_50%,#ede9fe_100%)] dark:bg-[linear-gradient(135deg,#0a1628_0%,#0d0f1a_50%,#1a0a2e_100%)]">
        <div class="noise-overlay pointer-events-none absolute inset-0 opacity-70"></div>
        <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-sky-400/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-violet-500/20 blur-3xl"></div>

        <div class="relative mx-auto grid w-full max-w-7xl gap-12 px-4 py-16 lg:grid-cols-2 lg:items-center lg:px-8 lg:py-24">
            <div>
                        <span class="mb-5 inline-flex items-center gap-2 rounded-full border border-sky-300/60 bg-sky-100/70 px-4 py-1 text-xs font-semibold text-sky-700 dark:border-sky-700 dark:bg-sky-900/30 dark:text-sky-200">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-sky-500"></span>
                            বাংলাদেশের প্রথম AI-চালিত প্রশ্নব্যাংক
                        </span>

                <h1 class="font-tiro text-4xl font-bold md:text-5xl">
                    স্মার্ট শিক্ষার জন্য <br>
                    <span class="inline-block bg-gradient-to-r from-sky-600 to-violet-600 bg-clip-text text-transparent pt-2 pb-1">ডিজিটাল প্রশ্নভান্ডার</span>
                </h1>

                <p class="mt-5 max-w-xl text-base leading-8 text-slate-600 dark:text-slate-300">
                    শিক্ষক থেকে শিক্ষার্থী — সবার জন্য একটি প্ল্যাটফর্ম। প্রশ্ন তৈরি করুন, পরীক্ষা নিন, অনুশীলন করুন এবং সাফল্য অর্জন করুন।
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#pricing" class="rounded-xl bg-gradient-to-r from-sky-600 to-violet-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-sky-600/30 transition hover:-translate-y-0.5">বিনামূল্যে শুরু করুন →</a>
                    <a href="#features" class="rounded-xl border-2 border-sky-200 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-sky-500 hover:text-sky-600 dark:border-slate-700 dark:text-slate-200">ফিচার দেখুন</a>
                </div>

                <div class="mt-10 grid grid-cols-3 gap-5">
                    <div><p class="font-tiro text-2xl font-bold text-sky-600 dark:text-sky-400">৫০,০০০+</p><p class="text-xs text-slate-500 dark:text-slate-400">সক্রিয় ব্যবহারকারী</p></div>
                    <div><p class="font-tiro text-2xl font-bold text-sky-600 dark:text-sky-400">৫ লক্ষ+</p><p class="text-xs text-slate-500 dark:text-slate-400">প্রশ্নের সংখ্যা</p></div>
                    <div><p class="font-tiro text-2xl font-bold text-sky-600 dark:text-sky-400">১,২০০+</p><p class="text-xs text-slate-500 dark:text-slate-400">শিক্ষা প্রতিষ্ঠান</p></div>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-3xl border border-sky-200/60 bg-white/85 p-6 shadow-2xl backdrop-blur dark:border-sky-700/40 dark:bg-slate-900/85">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-r from-sky-600 to-violet-600 text-xl text-white">📝</span>
                        <div>
                            <p class="text-sm font-bold">গণিত অধ্যায় ৫ — পরীক্ষা</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">৩০ মিনিট · ১৫টি প্রশ্ন</p>
                        </div>
                    </div>

                    <div class="space-y-3 text-sm">
                        <article class="rounded-xl border-s-4 border-sky-500 bg-slate-100 p-3 dark:bg-slate-800">
                            <p class="font-semibold">প্র ০১: নিচের কোনটি মৌলিক সংখ্যা?</p>
                            <ul class="mt-2 space-y-1 text-xs text-slate-600 dark:text-slate-300">
                                <li>ক) ৪</li><li>খ) ৬</li><li class="font-semibold text-emerald-600 dark:text-emerald-400">গ) ৭ ✓</li><li>ঘ) ৯</li>
                            </ul>
                        </article>
                        <article class="rounded-xl border-s-4 border-sky-500 bg-slate-100 p-3 dark:bg-slate-800">
                            <p class="font-semibold">প্র ০২: ২ + ২ × ৩ = ?</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">সঠিক উত্তর লিখুন...</p>
                        </article>
                    </div>
                </div>
                <div class="absolute -left-4 -top-4 rounded-xl border border-emerald-300 bg-white/90 px-3 py-1 text-xs font-semibold text-emerald-600 shadow-lg dark:border-emerald-700 dark:bg-slate-900">✅ ৯৪% সঠিক উত্তর</div>
                <div class="absolute -bottom-3 -right-3 rounded-xl border border-violet-300 bg-white/90 px-3 py-1 text-xs font-semibold text-violet-600 shadow-lg dark:border-violet-700 dark:bg-slate-900">🎯 র‍্যাংক: ১ম</div>
            </div>
        </div>
    </section>

    <section class="border-y border-sky-200/50 bg-white py-12 dark:border-sky-700/30 dark:bg-[#13172b]">
        <div class="mx-auto grid w-full max-w-7xl gap-3 px-4 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">
            @foreach ([['৫০,০০০+', 'নিবন্ধিত ব্যবহারকারী'], ['৫ লক্ষ+', 'মোট প্রশ্নের সংখ্যা'], ['১,২০০+', 'শিক্ষা প্রতিষ্ঠান'], ['৯৮%', 'ব্যবহারকারী সন্তুষ্টি']] as [$count, $label])
                <div class="rounded-2xl border border-sky-100 bg-[#f8fbff] p-5 text-center dark:border-sky-700/30 dark:bg-slate-900/70">
                    <p class="font-tiro text-3xl font-bold text-sky-600 dark:text-sky-400">{{ $count }}</p>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $label }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mx-auto w-full max-w-7xl px-4 py-16 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">কাদের জন্য</p>
            <h2 class="font-tiro mt-3 text-3xl font-bold">আপনার প্রয়োজনে প্রশ্নব্যাংক</h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300">শিক্ষক ও শিক্ষার্থী উভয়ের জন্যই আমাদের আলাদা ও শক্তিশালী ফিচার রয়েছে।</p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            <article class="rounded-3xl border border-sky-200/60 bg-white p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl dark:border-sky-700/30 dark:bg-[#13172b]">
                <p class="text-4xl">👩‍🏫</p>
                <h3 class="mt-4 text-2xl font-bold">শিক্ষকদের জন্য</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">স্কুল, কলেজ ও কোচিং সেন্টারের জন্য সহজেই প্রশ্নপত্র তৈরি করুন। AI সহায়তায় মিনিটেই সম্পূর্ণ পরীক্ষা প্রস্তুত হয়।</p>
                <ul class="mt-5 space-y-2 text-sm text-slate-700 dark:text-slate-200">
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> MCQ, সংক্ষিপ্ত ও রচনামূলক প্রশ্ন তৈরি</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> বিষয় ও অধ্যায় অনুযায়ী প্রশ্নব্যাংক পরিচালনা</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> স্বয়ংক্রিয় উত্তরপত্র মূল্যায়ন</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> ছাত্রদের পারফরম্যান্স রিপোর্ট</li>
                </ul>
            </article>
            <article class="rounded-3xl border border-violet-200/70 bg-white p-8 shadow-lg transition hover:-translate-y-1 hover:shadow-xl dark:border-violet-700/30 dark:bg-[#13172b]">
                <p class="text-4xl">👨‍🎓</p>
                <h3 class="mt-4 text-2xl font-bold">শিক্ষার্থী ও চাকুরী প্রার্থীদের জন্য</h3>
                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-300">BCS, Bank, SSC, HSC সহ সব ধরনের পরীক্ষার অনুশীলন করুন এবং আপনার অগ্রগতি ট্র্যাক করুন।</p>
                <ul class="mt-5 space-y-2 text-sm text-slate-700 dark:text-slate-200">
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> বিগত বছরের প্রশ্নপত্রের অনুশীলন</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> মক টেস্ট ও লাইভ কুইজ</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> ব্যাখ্যাসহ উত্তর ও ড্যাশবোর্ড</li>
                    <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> লিডারবোর্ড ও ব্যাজ সিস্টেম</li>
                </ul>
            </article>
        </div>
    </section>

    <section id="features" class="bg-[#f0f4ff] px-4 py-16 dark:bg-[#111527] lg:px-8">
        <div class="mx-auto w-full max-w-7xl">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">ফিচারসমূহ</p>
                <h2 class="font-tiro mt-3 text-3xl font-bold">কেন প্রশ্নব্যাংক বেছে নেবেন?</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-300">আমাদের অত্যাধুনিক ফিচারগুলো শিক্ষাকে আরও সহজ, কার্যকর ও আনন্দময় করে তোলে।</p>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ([
                    ['🤖', 'AI প্রশ্ন জেনারেটর', 'কৃত্রিম বুদ্ধিমত্তার সাহায্যে যেকোনো বিষয়ের জন্য স্বয়ংক্রিয়ভাবে বিভিন্ন ধরনের প্রশ্ন তৈরি করুন।'],
                    ['📊', 'স্মার্ট অ্যানালিটিক্স', 'প্রতিটি ছাত্রের দুর্বল ও শক্তিশালী দিক বিশ্লেষণ করে ব্যক্তিগত শিক্ষা পরিকল্পনা তৈরি করুন।'],
                    ['⏱️', 'টাইমড মক টেস্ট', 'বাস্তব পরীক্ষার মতো পরিবেশে টাইমড মক টেস্ট দিন এবং পরীক্ষার ভয় জয় করুন।'],
                    ['🏆', 'লিডারবোর্ড ও র‍্যাংকিং', 'বন্ধু ও সহপাঠীদের সাথে প্রতিযোগিতামূলক কুইজে অংশ নিন এবং নিজের অবস্থান জানুন।'],
                    ['📚', 'বিষয়ভিত্তিক প্রশ্নব্যাংক', 'SSC, HSC, BCS, ব্যাংক জব সহ সকল প্রতিযোগিতামূলক পরীক্ষার জন্য সাজানো প্রশ্নভান্ডার।'],
                    ['🔔', 'স্মার্ট নোটিফিকেশন', 'পরীক্ষার সময়সূচি, নতুন প্রশ্নপত্র ও ফলাফলের রিয়েলটাইম আপডেট পান।'],
                ] as [$icon, $title, $description])
                    <article class="group relative overflow-hidden rounded-2xl border border-sky-200/60 bg-white p-6 shadow-sm transition-all hover:-translate-y-1 hover:shadow-xl dark:border-sky-700/30 dark:bg-[#13172b]">
                        <div class="absolute bottom-0 left-0 h-1 w-full scale-x-0 bg-gradient-to-r from-sky-600 to-violet-600 transition-transform duration-300 origin-left group-hover:scale-x-100"></div>
                        <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-sky-50 text-2xl dark:bg-slate-800">{{ $icon }}</div>
                        <h3 class="text-lg font-bold">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="howto" class="mx-auto w-full max-w-7xl px-4 py-16 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">প্রক্রিয়া</p>
            <h2 class="font-tiro mt-3 text-3xl font-bold">কিভাবে শুরু করবেন?</h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300">মাত্র তিনটি ধাপে শুরু করুন এবং আপনার শিক্ষাজীবন বদলে ফেলুন।</p>
        </div>
        <div class="mt-10 grid gap-8 md:grid-cols-3 relative">
            <div class="hidden md:block absolute top-7 left-[16.66%] right-[16.66%] h-0.5 bg-gradient-to-r from-sky-600 to-violet-600 z-0"></div>

            @foreach ([
                ['১', 'অ্যাকাউন্ট তৈরি করুন', 'আপনার ভূমিকা (শিক্ষক/শিক্ষার্থী) নির্বাচন করে বিনামূল্যে নিবন্ধন করুন।'],
                ['২', 'বিষয় ও লক্ষ্য নির্ধারণ করুন', 'আপনার পড়াশোনার বিষয়, পরীক্ষার ধরন ও লক্ষ্য নির্ধারণ করুন।'],
                ['৩', 'শুরু করুন ও এগিয়ে যান', 'প্রশ্ন তৈরি বা অনুশীলন শুরু করুন এবং প্রতিদিন আগের চেয়ে ভালো হোন।']
            ] as [$step, $title, $desc])
                <article class="text-center relative z-10">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-r from-sky-600 to-violet-600 text-xl font-bold text-white shadow-lg">{{ $step }}</div>
                    <h3 class="mt-4 text-lg font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 max-w-xs mx-auto leading-relaxed">{{ $desc }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="pricing" class="bg-[#f0f4ff] px-4 py-16 dark:bg-[#111527] lg:px-8">
        <div class="mx-auto w-full max-w-7xl">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">মূল্য তালিকা</p>
                <h2 class="font-tiro mt-3 text-3xl font-bold">আপনার বাজেটে সেরা পরিকল্পনা</h2>
                <p class="mt-3 text-slate-600 dark:text-slate-300">স্বচ্ছ মূল্য নীতি, কোনো লুকানো চার্জ নেই। যেকোনো সময় পরিবর্তন বা বাতিল করুন।</p>
            </div>
            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <article class="rounded-3xl border border-sky-200 bg-white p-8 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-sky-700/30 dark:bg-[#13172b]">
                    <p class="text-xs font-bold tracking-[0.2em] text-slate-500 uppercase">বিনামূল্যে</p>
                    <p class="font-tiro mt-3 text-5xl font-bold text-slate-900 dark:text-white">৳০<span class="text-lg text-slate-500 font-sans font-normal">/মাস</span></p>
                    <p class="text-xs text-slate-500 mt-2">চিরকালের জন্য বিনামূল্যে</p>
                    <ul class="mt-6 mb-8 space-y-3 text-sm text-slate-600 dark:text-slate-300 text-left flex flex-col items-center">
                        <div class="space-y-3">
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> ৫০টি প্রশ্ন তৈরি</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> মাসে ৫টি মক টেস্ট</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> বেসিক অ্যানালিটিক্স</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> কমিউনিটি সাপোর্ট</li>
                        </div>
                    </ul>
                    <button class="w-full rounded-xl border-2 border-sky-600 bg-transparent px-6 py-3 text-sm font-bold text-sky-600 transition hover:bg-sky-600 hover:text-white">বিনামূল্যে শুরু করুন</button>
                </article>

                <article class="relative rounded-3xl bg-gradient-to-r from-sky-600 to-violet-600 p-8 text-center text-white shadow-2xl lg:scale-105 z-10">
                    <span class="absolute -top-3 left-1/2 -translate-x-1/2 rounded-full bg-amber-400 px-4 py-1 text-xs font-bold text-slate-900 uppercase tracking-wider">সবচেয়ে জনপ্রিয়</span>
                    <p class="text-xs font-bold tracking-[0.2em] uppercase text-white/80">প্রো</p>
                    <p class="font-tiro mt-3 text-5xl font-bold">৳৪৯৯<span class="text-lg text-white/80 font-sans font-normal">/মাস</span></p>
                    <p class="text-xs text-white/80 mt-2">বার্ষিক পরিশোধে ২০% ছাড়</p>
                    <ul class="mt-6 mb-8 space-y-3 text-sm text-white/95 text-left flex flex-col items-center">
                        <div class="space-y-3">
                            <li class="flex gap-2"><span class="font-bold">✓</span> অসীমিত প্রশ্ন তৈরি</li>
                            <li class="flex gap-2"><span class="font-bold">✓</span> AI প্রশ্ন জেনারেটর</li>
                            <li class="flex gap-2"><span class="font-bold">✓</span> সকল মক টেস্ট ও কুইজ</li>
                            <li class="flex gap-2"><span class="font-bold">✓</span> বিস্তারিত অ্যানালিটিক্স</li>
                            <li class="flex gap-2"><span class="font-bold">✓</span> PDF ডাউনলোড</li>
                        </div>
                    </ul>
                    <button class="w-full rounded-xl bg-white px-6 py-3 text-sm font-bold text-sky-600 transition hover:bg-transparent hover:border hover:border-white hover:text-white">প্রো শুরু করুন</button>
                </article>

                <article class="rounded-3xl border border-sky-200 bg-white p-8 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-xl dark:border-sky-700/30 dark:bg-[#13172b]">
                    <p class="text-xs font-bold tracking-[0.2em] text-slate-500 uppercase">ইনস্টিটিউট</p>
                    <p class="font-tiro mt-3 text-5xl font-bold text-slate-900 dark:text-white">৳২,৯৯৯<span class="text-lg text-slate-500 font-sans font-normal">/মাস</span></p>
                    <p class="text-xs text-slate-500 mt-2">সর্বোচ্চ ১০০ শিক্ষার্থী</p>
                    <ul class="mt-6 mb-8 space-y-3 text-sm text-slate-600 dark:text-slate-300 text-left flex flex-col items-center">
                        <div class="space-y-3">
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> সম্পূর্ণ প্রতিষ্ঠান পরিচালনা</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> একাধিক শিক্ষক অ্যাকাউন্ট</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> কাস্টম ব্র্যান্ডিং</li>
                            <li class="flex gap-2"><span class="text-emerald-500 font-bold">✓</span> ডেডিকেটেড সাপোর্ট</li>
                        </div>
                    </ul>
                    <button class="w-full rounded-xl border-2 border-sky-600 bg-transparent px-6 py-3 text-sm font-bold text-sky-600 transition hover:bg-sky-600 hover:text-white">যোগাযোগ করুন</button>
                </article>
            </div>
        </div>
    </section>

    <section class="mx-auto w-full max-w-7xl px-4 py-16 lg:px-8">
        <div class="text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">ব্যবহারকারীদের মতামত</p>
            <h2 class="font-tiro mt-3 text-3xl font-bold">তারা যা বলেন</h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300">হাজার হাজার শিক্ষক ও শিক্ষার্থী প্রতিদিন আমাদের প্ল্যাটফর্ম ব্যবহার করছেন।</p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            <article class="rounded-2xl border border-sky-200/60 bg-white p-6 shadow-sm transition hover:-translate-y-1 dark:border-sky-700/30 dark:bg-[#13172b]">
                <div class="text-amber-400 text-lg tracking-widest mb-4">★★★★★</div>
                <p class="text-sm italic text-slate-600 dark:text-slate-300 leading-relaxed mb-5">"প্রশ্নব্যাংক ব্যবহার করে আমার কোচিং সেন্টারের পরীক্ষা পদ্ধতি সম্পূর্ণ বদলে গেছে। মাত্র ৫ মিনিটে পুরো প্রশ্নপত্র তৈরি হয়ে যায়!"</p>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-sky-600 to-violet-600 text-sm font-bold text-white">রা</div>
                    <div>
                        <p class="text-sm font-bold">রাহেলা বেগম</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">শিক্ষিকা, ঢাকা কোচিং সেন্টার</p>
                    </div>
                </div>
            </article>

            <article class="rounded-2xl border border-sky-200/60 bg-white p-6 shadow-sm transition hover:-translate-y-1 dark:border-sky-700/30 dark:bg-[#13172b]">
                <div class="text-amber-400 text-lg tracking-widest mb-4">★★★★★</div>
                <p class="text-sm italic text-slate-600 dark:text-slate-300 leading-relaxed mb-5">"BCS পরীক্ষার প্রস্তুতিতে প্রশ্নব্যাংক আমার সেরা সঙ্গী। প্রতিটি প্রশ্নের বিস্তারিত ব্যাখ্যা পড়ে অনেক কিছু শিখেছি।"</p>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-sky-600 to-violet-600 text-sm font-bold text-white">ক</div>
                    <div>
                        <p class="text-sm font-bold">করিম আহমেদ</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">BCS প্রার্থী, চট্টগ্রাম</p>
                    </div>
                </div>
            </article>

            <article class="rounded-2xl border border-sky-200/60 bg-white p-6 shadow-sm transition hover:-translate-y-1 dark:border-sky-700/30 dark:bg-[#13172b]">
                <div class="text-amber-400 text-lg tracking-widest mb-4">★★★★★</div>
                <p class="text-sm italic text-slate-600 dark:text-slate-300 leading-relaxed mb-5">"আমাদের স্কুলে এখন সব পরীক্ষা ডিজিটালি হচ্ছে। শিক্ষার্থীরা তাৎক্ষণিক ফলাফল পাচ্ছে। অসাধারণ প্ল্যাটফর্ম!"</p>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-sky-600 to-violet-600 text-sm font-bold text-white">স</div>
                    <div>
                        <p class="text-sm font-bold">সালমা খানম</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">প্রধান শিক্ষক, ময়মনসিংহ</p>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <section class="relative bg-gradient-to-r from-sky-600 to-violet-600 px-4 py-20 text-center text-white lg:px-8 overflow-hidden">
        <div class="noise-overlay pointer-events-none absolute inset-0 opacity-20"></div>
        <div class="relative z-10">
            <h2 class="font-tiro text-4xl font-bold">আজই শুরু করুন — বিনামূল্যে!</h2>
            <p class="mx-auto mt-4 max-w-2xl text-white/85 text-lg">হাজার হাজার শিক্ষক ও শিক্ষার্থীর সাথে যোগ দিন এবং আপনার শিক্ষাজীবনকে নতুন উচ্চতায় নিয়ে যান।</p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="rounded-xl bg-white px-8 py-3.5 text-sm font-bold text-sky-700 shadow-lg transition hover:-translate-y-1 hover:shadow-xl">বিনামূল্যে অ্যাকাউন্ট তৈরি করুন</a>
                @endif
                <a href="#features" class="rounded-xl border-2 border-white/60 bg-transparent px-8 py-3.5 text-sm font-bold text-white transition hover:bg-white/10 hover:border-white">লাইভ ডেমো দেখুন</a>
            </div>
        </div>
    </section>

    <section id="faq" class="mx-auto w-full max-w-4xl px-4 py-20 lg:px-8">
        <div class="text-center">
            <p class="text-xs font-bold tracking-[0.2em] text-sky-600 uppercase">সাধারণ জিজ্ঞাসা</p>
            <h2 class="font-tiro mt-3 text-3xl font-bold">কোনো প্রশ্ন আছে?</h2>
            <p class="mt-3 text-slate-600 dark:text-slate-300">আমাদের সবচেয়ে সাধারণ প্রশ্নগুলোর উত্তর এখানে পাবেন।</p>
        </div>
        <div class="mt-10 space-y-3">
            @foreach ([
                'প্রশ্নব্যাংক কি সম্পূর্ণ বিনামূল্যে ব্যবহার করা যাবে?' => 'হ্যাঁ, আমাদের ফ্রি প্ল্যানে আপনি সীমিত সংখ্যক প্রশ্ন তৈরি ও অনুশীলন করতে পারবেন। বেশি সুবিধার জন্য প্রো বা ইনস্টিটিউট প্ল্যানে আপগ্রেড করুন।',
                'শিক্ষকরা কি তাদের নিজস্ব প্রশ্নব্যাংক তৈরি করতে পারবেন?' => 'অবশ্যই! শিক্ষকরা নিজস্ব প্রশ্নব্যাংক তৈরি করে সেটি তাদের ক্লাস বা কোচিং সেন্টারের শিক্ষার্থীদের সাথে শেয়ার করতে পারবেন।',
                'কোন কোন পরীক্ষার প্রস্তুতির জন্য উপযুক্ত?' => 'PSC, JSC, SSC, HSC, অনার্স ভর্তি, BCS, ব্যাংক জব, প্রাইমারি শিক্ষক নিয়োগ সহ সকল ধরনের পরীক্ষার জন্য আমাদের প্ল্যাটফর্ম উপযুক্ত।',
                'মোবাইলে ব্যবহার করা যাবে?' => 'হ্যাঁ, আমাদের প্ল্যাটফর্ম মোবাইল-ফার্স্ট ডিজাইনে তৈরি। Android ও iOS অ্যাপও শীঘ্রই আসছে।',
                'সাবস্ক্রিপশন বাতিল করতে পারব?' => 'যেকোনো সময় কোনো চার্জ ছাড়াই সাবস্ক্রিপশন বাতিল করতে পারবেন। পেইড পিরিয়ড শেষ না হওয়া পর্যন্ত সমস্ত সুবিধা উপভোগ করতে পারবেন।'
            ] as $question => $answer)
                <article class="faq-item overflow-hidden rounded-xl border border-sky-200/60 transition-colors hover:border-sky-400/60 dark:border-sky-700/40">
                    <button type="button" class="faq-toggle-btn flex w-full items-center justify-between bg-white px-6 py-5 text-left text-[15px] font-semibold transition dark:bg-[#13172b] hover:text-sky-600 dark:hover:text-sky-400">
                        <span>{{ $question }}</span>
                        <span class="faq-symbol flex h-7 w-7 items-center justify-center rounded-full bg-sky-50 text-xl text-sky-600 transition-transform duration-300 dark:bg-slate-800 dark:text-sky-400">+</span>
                    </button>
                    <div class="faq-content hidden border-t border-sky-100 bg-[#f8fbff] px-6 py-5 text-sm leading-relaxed text-slate-600 dark:border-sky-700/30 dark:bg-[#111527] dark:text-slate-300">{{ $answer }}</div>
                </article>
            @endforeach
        </div>
    </section>
</main>

<footer class="border-t border-sky-200/60 bg-white pt-16 pb-8 px-4 dark:border-sky-700/30 dark:bg-[#13172b] lg:px-8">
    <div class="mx-auto w-full max-w-7xl">
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4 mb-12">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 text-sky-600 dark:text-sky-400 mb-4">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-sky-600 text-xs font-bold text-white">প্র</span>
                    <span class="font-tiro text-xl font-bold">প্রশ্নব্যাংক</span>
                </a>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed max-w-xs">বাংলাদেশের শিক্ষার্থী ও শিক্ষকদের জন্য সেরা ডিজিটাল প্রশ্নভান্ডার ও পরীক্ষা ব্যবস্থাপনা প্ল্যাটফর্ম।</p>
            </div>

            <div>
                <h5 class="font-bold mb-4 text-slate-800 dark:text-slate-200">পণ্য</h5>
                <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#features" class="transition hover:text-sky-600">ফিচারসমূহ</a></li>
                    <li><a href="#pricing" class="transition hover:text-sky-600">মূল্য তালিকা</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">AI জেনারেটর</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">মক টেস্ট</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold mb-4 text-slate-800 dark:text-slate-200">কোম্পানি</h5>
                <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#" class="transition hover:text-sky-600">আমাদের সম্পর্কে</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">ব্লগ</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">ক্যারিয়ার</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">যোগাযোগ</a></li>
                </ul>
            </div>

            <div>
                <h5 class="font-bold mb-4 text-slate-800 dark:text-slate-200">সহায়তা</h5>
                <ul class="space-y-3 text-sm text-slate-500 dark:text-slate-400">
                    <li><a href="#" class="transition hover:text-sky-600">সাহায্য কেন্দ্র</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">গোপনীয়তা নীতি</a></li>
                    <li><a href="#" class="transition hover:text-sky-600">সেবার শর্তাবলী</a></li>
                    <li><a href="#faq" class="transition hover:text-sky-600">সাধারণ জিজ্ঞাসা</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-sky-100 dark:border-sky-800/50 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-500 dark:text-slate-400">
            <p>© ২০২৬ প্রশ্নব্যাংক। সর্বস্বত্ব সংরক্ষিত।</p>
            <div class="flex gap-3">
                <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 dark:bg-slate-800 hover:bg-sky-600 hover:text-white transition">f</a>
                <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 dark:bg-slate-800 hover:bg-sky-600 hover:text-white transition">t</a>
                <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 dark:bg-slate-800 hover:bg-sky-600 hover:text-white transition">in</a>
                <a href="#" class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 dark:bg-slate-800 hover:bg-sky-600 hover:text-white transition">yt</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Theme Toggle Logic
    const htmlElement = document.documentElement;
    const themeToggleButton = document.getElementById('theme-toggle');
    const themeKnob = document.getElementById('theme-knob');
    const menuToggleButton = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    const updateKnobPosition = () => {
        if (htmlElement.classList.contains('dark')) {
            themeKnob.classList.add('translate-x-5');
        } else {
            themeKnob.classList.remove('translate-x-5');
        }
    };

    updateKnobPosition();

    themeToggleButton?.addEventListener('click', () => {
        htmlElement.classList.toggle('dark');
        localStorage.setItem('qb-theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
        updateKnobPosition();
    });

    // Mobile Menu Toggle
    menuToggleButton?.addEventListener('click', () => {
        mobileMenu?.classList.toggle('hidden');
    });

    // FAQ Accordion Logic
    document.querySelectorAll('.faq-toggle-btn').forEach((button) => {
        button.addEventListener('click', () => {
            const item = button.closest('.faq-item');
            const content = item?.querySelector('.faq-content');
            const symbol = item?.querySelector('.faq-symbol');
            const isHidden = content?.classList.contains('hidden');

            // Close all others
            document.querySelectorAll('.faq-content').forEach((panel) => panel.classList.add('hidden'));
            document.querySelectorAll('.faq-symbol').forEach((icon) => {
                icon.textContent = '+';
                icon.classList.remove('rotate-45', 'bg-sky-600', 'text-white');
            });

            // Open clicked one
            if (isHidden) {
                content?.classList.remove('hidden');
                if (symbol) {
                    symbol.textContent = '+';
                    symbol.classList.add('rotate-45', 'bg-sky-600', 'text-white');
                }
            }
        });
    });
</script>
</body>
</html>

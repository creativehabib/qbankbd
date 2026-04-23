<!DOCTYPE html>
<html lang="bn" class="h-full scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>প্রশ্নভান্ডার - স্মার্ট প্রশ্নব্যাংক প্ল্যাটফর্ম</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <script>
            (function () {
                const preferredTheme = localStorage.getItem('qb-theme');
                const systemDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const theme = preferredTheme ?? (systemDarkMode ? 'dark' : 'light');

                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-full bg-slate-50 text-slate-900 antialiased transition-colors duration-300 dark:bg-slate-950 dark:text-slate-100">
        <div class="relative overflow-hidden">
            <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[520px] bg-[radial-gradient(circle_at_top,_#0ea5e9_0%,_transparent_60%)] opacity-20 dark:opacity-25"></div>

            <header class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-600 text-lg font-extrabold text-white shadow-lg shadow-sky-600/30">Q</span>
                    <span>
                        <span class="block text-lg font-extrabold leading-tight">প্রশ্নভান্ডার</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">Teacher & Student Smart Platform</span>
                    </span>
                </a>

                <div class="flex items-center gap-2">
                    <button id="theme-toggle" type="button" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm font-semibold shadow-sm transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800">
                        <span id="theme-icon" aria-hidden="true">🌙</span>
                        <span id="theme-label">ডার্ক মোড</span>
                    </button>
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="rounded-xl bg-sky-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-sky-600/30 transition hover:bg-sky-700">লগইন</a>
                    @endif
                </div>
            </header>

            <main>
                <section class="mx-auto grid w-full max-w-7xl gap-10 px-6 pb-16 pt-6 lg:grid-cols-2 lg:items-center lg:px-8 lg:pb-24">
                    <div>
                        <p class="mb-4 inline-flex rounded-full border border-sky-200 bg-sky-100/80 px-4 py-1 text-sm font-semibold text-sky-700 dark:border-sky-900 dark:bg-sky-900/30 dark:text-sky-200">দেশব্যাপী প্রশ্ন তৈরী ও অনুশীলনের আধুনিক সমাধান</p>
                        <h1 class="text-4xl font-black leading-tight md:text-5xl">
                            শিক্ষক থেকে চাকরিপ্রার্থী—<span class="text-sky-600 dark:text-sky-400">সবার জন্য ইউনিক প্রশ্ন ব্যাংক</span>
                        </h1>
                        <p class="mt-5 max-w-xl text-base text-slate-600 md:text-lg dark:text-slate-300">
                            স্কুল, কলেজ ও কোচিং সেন্টারের শিক্ষকরা সহজে প্রশ্ন তৈরি, সেট সাজানো, PDF এক্সপোর্ট এবং ক্লাসভিত্তিক শেয়ার করতে পারবেন।
                            শিক্ষার্থী ও চাকরিপ্রার্থীরা টাইমড মক টেস্ট, ব্যাখ্যাসহ উত্তর এবং পারফরম্যান্স অ্যানালিটিক্স দিয়ে নিয়মিত অনুশীলন করতে পারবে।
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#teacher" class="rounded-xl bg-sky-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-sky-600/30 transition hover:bg-sky-700">শিক্ষক ফিচার দেখুন</a>
                            <a href="#student" class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-bold transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-900 dark:hover:bg-slate-800">স্টুডেন্ট প্র্যাকটিস দেখুন</a>
                        </div>
                        <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800"><p class="text-2xl font-black text-sky-600 dark:text-sky-400">৫০K+</p><p class="text-xs text-slate-500 dark:text-slate-400">প্রশ্ন</p></div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800"><p class="text-2xl font-black text-sky-600 dark:text-sky-400">১২০০+</p><p class="text-xs text-slate-500 dark:text-slate-400">শিক্ষক</p></div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800"><p class="text-2xl font-black text-sky-600 dark:text-sky-400">২L+</p><p class="text-xs text-slate-500 dark:text-slate-400">শিক্ষার্থী</p></div>
                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800"><p class="text-2xl font-black text-sky-600 dark:text-sky-400">৯৮%</p><p class="text-xs text-slate-500 dark:text-slate-400">সন্তুষ্টি</p></div>
                        </div>
                    </div>

                    <div class="relative">
                        <div class="rounded-3xl bg-gradient-to-br from-sky-500 to-indigo-700 p-1 shadow-2xl shadow-sky-900/30">
                            <div class="rounded-[22px] bg-white p-6 dark:bg-slate-900">
                                <div class="grid gap-4">
                                    <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-700">
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Teacher Console</p>
                                        <p class="mt-2 text-lg font-bold">সেট: ভর্তি প্রস্তুতি ২০২৬</p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">MCQ 60 • CQ 10 • Short 20</p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-700">
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400">Student Practice</p>
                                        <div class="mt-3 h-3 overflow-hidden rounded-full bg-slate-200 dark:bg-slate-800">
                                            <div class="h-full w-3/4 rounded-full bg-emerald-500"></div>
                                        </div>
                                        <p class="mt-2 text-sm">Mock Test Progress: <span class="font-bold">75%</span></p>
                                    </div>
                                    <div class="rounded-2xl border border-slate-200 p-4 dark:border-slate-700">
                                        <p class="text-sm font-bold text-slate-500 dark:text-slate-400">AI Suggestion</p>
                                        <p class="mt-2 text-sm">“টপিক কভারেজ ব্যালেন্স করতে আরও ৮টি শর্ট প্রশ্ন যুক্ত করুন।”</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="teacher" class="mx-auto w-full max-w-7xl px-6 py-10 lg:px-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-black">শিক্ষকদের জন্য পাওয়ারফুল টুলস</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">একই প্ল্যাটফর্ম থেকে প্রশ্ন তৈরি, ম্যানেজ ও শেয়ার করুন।</p>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach ([
                            'প্রশ্ন বিল্ডার' => 'চ্যাপ্টার/টপিক/ডিফিকাল্টি অনুযায়ী দ্রুত প্রশ্ন তৈরি করুন।',
                            'প্রশ্ন সেট জেনারেটর' => 'একাধিক পরীক্ষার জন্য ভিন্ন ভিন্ন সেট অটো তৈরি করুন।',
                            'রুব্রিক ও মার্কিং' => 'CQ/রাইটিং প্রশ্নের জন্য মার্কিং স্কিম ও নির্দেশনা দিন।',
                            'PDF + প্রিন্ট' => 'A4/Booklet ফরম্যাটে এক ক্লিকে রপ্তানি ও প্রিন্ট।',
                        ] as $title => $description)
                            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg dark:bg-slate-900 dark:ring-slate-800">
                                <h3 class="text-lg font-extrabold">{{ $title }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $description }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section id="student" class="mx-auto w-full max-w-7xl px-6 py-10 lg:px-8">
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-black">শিক্ষার্থী ও চাকরিপ্রার্থীদের জন্য স্মার্ট প্র্যাকটিস</h2>
                        <p class="mt-2 text-slate-600 dark:text-slate-300">দৈনিক অনুশীলন, ব্যাখ্যা, টাইমার এবং র‍্যাঙ্কিং সিস্টেম।</p>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                        @foreach ([
                            'টাইমড মক টেস্ট' => 'পরীক্ষার মতো পরিবেশে নির্দিষ্ট সময়ে প্রশ্ন সমাধান করুন।',
                            'ব্যাখ্যাসহ সমাধান' => 'ভুল উত্তর বিশ্লেষণ করে ধারণা পরিষ্কার করুন।',
                            'পারফরম্যান্স অ্যানালিটিক্স' => 'টপিকভিত্তিক দুর্বলতা ও অগ্রগতি ট্র্যাক করুন।',
                            'লিডারবোর্ড' => 'বন্ধুদের সাথে প্রতিযোগিতায় মোটিভেশন ধরে রাখুন।',
                        ] as $title => $description)
                            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-lg dark:bg-slate-900 dark:ring-slate-800">
                                <h3 class="text-lg font-extrabold">{{ $title }}</h3>
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $description }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>

                <section class="mx-auto w-full max-w-7xl px-6 pb-20 pt-8 lg:px-8">
                    <div class="rounded-3xl bg-slate-900 p-8 text-center text-white dark:bg-sky-900">
                        <h2 class="text-3xl font-black">আজই আপনার প্রতিষ্ঠানকে ডিজিটাল প্রশ্নব্যাংকে আনুন</h2>
                        <p class="mx-auto mt-3 max-w-3xl text-sm text-slate-300 dark:text-sky-100">স্কুল, কলেজ, কোচিং সেন্টার এবং জব প্রিপারেশন ব্যাচ—সবকিছু এক প্ল্যাটফর্মে।</p>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-900 transition hover:bg-slate-100">ফ্রি অ্যাকাউন্ট খুলুন</a>
                            @endif
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="rounded-xl border border-white/40 px-6 py-3 text-sm font-bold transition hover:bg-white/10">ডেমো লগইন</a>
                            @endif
                        </div>
                    </div>
                </section>
            </main>
        </div>

        <script>
            const htmlElement = document.documentElement;
            const toggleButton = document.getElementById('theme-toggle');
            const themeLabel = document.getElementById('theme-label');
            const themeIcon = document.getElementById('theme-icon');

            const updateThemeButton = () => {
                const isDark = htmlElement.classList.contains('dark');
                themeLabel.textContent = isDark ? 'লাইট মোড' : 'ডার্ক মোড';
                themeIcon.textContent = isDark ? '☀️' : '🌙';
            };

            updateThemeButton();

            toggleButton?.addEventListener('click', () => {
                htmlElement.classList.toggle('dark');
                localStorage.setItem('qb-theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
                updateThemeButton();
            });
        </script>
    </body>
</html>

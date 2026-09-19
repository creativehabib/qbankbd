@extends('layouts.frontend')

@section('title', 'বিগত পরীক্ষার প্রশ্ন ও সমাধান — Qerobi')
@section('description', 'বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও ভর্তি পরীক্ষার বিগত প্রশ্ন, শিক্ষক-যাচাই করা ব্যাখ্যাসহ সমাধান এবং প্রতিষ্ঠানভিত্তিক প্রশ্ন আর্কাইভ।')

@section('content')
    <div class="space-y-14 sm:space-y-20">

        <!-- ============================================== -->
        <!-- HERO — ruled paper, left aligned, search leads -->
        <!-- ============================================== -->
        <section class="relative rounded-3xl border border-slate-200 dark:border-slate-800 bg-gradient-to-br from-emerald-50/60 via-white to-teal-50/50 dark:from-[#121b2a] dark:via-[#0B1120] dark:to-[#0a1922] overflow-hidden">

            <!-- Ruled exercise-book lines -->
            <div class="absolute inset-0 pointer-events-none bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(15,23,42,0.05)_35px,rgba(15,23,42,0.05)_36px)] dark:bg-[repeating-linear-gradient(to_bottom,transparent_0px,transparent_35px,rgba(148,163,184,0.06)_35px,rgba(148,163,184,0.06)_36px)]"></div>

            <div class="relative grid lg:grid-cols-12 gap-10 px-6 py-10 sm:px-10 sm:py-14">

                <div class="lg:col-span-7">
                    <p class="flex items-center gap-3 text-[13px] font-semibold text-emerald-600 dark:text-emerald-400 mb-5">
                        <span class="w-6 h-0.5 bg-emerald-500 rounded-full"></span>
                        হালনাগাদ ১৮ সেপ্টেম্বর, ২০২৬
                    </p>

                    <h1 class="text-[2rem] sm:text-5xl lg:text-[3.25rem] font-extrabold text-slate-900 dark:text-white leading-[1.3] tracking-tight">
                        প্রশ্ন খুঁজুন,<br/>উত্তর মিলিয়ে নিন।
                    </h1>

                    <p class="mt-5 text-[15px] sm:text-base text-slate-600 dark:text-slate-400 leading-[1.9] max-w-xl">
                        বিসিএস, ব্যাংক, শিক্ষক নিয়োগ ও ভর্তি পরীক্ষার বিগত প্রশ্ন — প্রতিটি উত্তর শিক্ষক দ্বারা যাচাই করা। ভুল মনে হলে প্রশ্নের নিচেই আপত্তি জানাতে পারবেন।
                    </p>

                    <!-- Search: the one loud element on the page -->
                    <div class="mt-9 max-w-xl">
                        <label for="qb-search" class="block text-[13px] font-semibold text-slate-900 dark:text-slate-300 mb-2">কী খুঁজছেন?</label>
                        <div class="flex items-stretch border-b-2 border-slate-900 dark:border-slate-600 focus-within:border-emerald-500 dark:focus-within:border-emerald-400 transition-colors">
                            <input id="qb-search" type="text" readonly
                                   onclick="window.dispatchEvent(new CustomEvent('open-search'))"
                                   placeholder="সমাস, ৫০তম বিসিএস, প্রাথমিক শিক্ষক ২০২৪…"
                                   class="w-full bg-transparent px-1 py-3 text-base sm:text-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none cursor-pointer">
                            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'))"
                                    class="shrink-0 px-5 py-3 text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-slate-900 dark:hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded transition-colors">
                                খুঁজুন
                            </button>
                        </div>
                        <p class="mt-3 text-[13px] text-slate-500 dark:text-slate-400">
                            ৩২০টি পরীক্ষার ১২,৪০০+ প্রশ্ন সমাধানসহ সংরক্ষিত।
                        </p>

                        <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-4 text-[13px]">
                            <a href="#" class="font-medium text-slate-700 dark:text-slate-300 underline decoration-slate-300 dark:decoration-slate-700 underline-offset-4 hover:decoration-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">শিক্ষক নিয়োগ</a>
                            <a href="#" class="font-medium text-slate-700 dark:text-slate-300 underline decoration-slate-300 dark:decoration-slate-700 underline-offset-4 hover:decoration-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">বিসিএস প্রশ্ন</a>
                            <a href="#" class="font-medium text-slate-700 dark:text-slate-300 underline decoration-slate-300 dark:decoration-slate-700 underline-offset-4 hover:decoration-emerald-500 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">মডেল টেস্ট</a>
                        </div>
                    </div>
                </div>

                <!-- Quiet live panel: what closes soonest -->
                <aside class="lg:col-span-5 lg:pl-8 lg:border-l border-slate-200 dark:border-slate-800">
                    <h2 class="text-[13px] font-bold text-slate-900 dark:text-slate-300 mb-4">আবেদনের সময় ফুরাচ্ছে</h2>
                    <ul>
                        <li class="flex items-baseline justify-between gap-4 py-3 border-t border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">খাদ্য অধিদপ্তর, উপ-পরিদর্শক</a>
                            <span class="text-[13px] font-bold text-rose-700 dark:text-rose-300">আজ শেষ</span>
                        </li>
                        <li class="flex items-baseline justify-between gap-4 py-3 border-t border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">বাংলাদেশ রেলওয়ে, ওয়েম্যান</a>
                            <span class="shrink-0 text-xs font-medium text-slate-500 dark:text-slate-400">৪ দিন বাকি</span>
                        </li>
                        <li class="flex items-baseline justify-between gap-4 py-3 border-y border-slate-200 dark:border-slate-800">
                            <a href="#" class="text-sm font-semibold text-slate-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">বাংলাদেশ ব্যাংক, অফিসার</a>
                            <span class="shrink-0 text-xs font-medium text-slate-500 dark:text-slate-400">১০ দিন বাকি</span>
                        </li>
                    </ul>
                    <a href="#" class="inline-block mt-4 text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">সব বিজ্ঞপ্তি দেখুন</a>
                </aside>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- WHAT YOU CAN DO — four columns, hairline split -->
        <!-- ============================================== -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-px bg-slate-200 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden">
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">জব সল্যুশন</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">বিগত পরীক্ষার প্রশ্ন, ব্যাখ্যাসহ উত্তর</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">প্রশ্ন আর্কাইভ</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">প্রতিষ্ঠান ও সাল ধরে সাজানো</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">মডেল টেস্ট</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">সময় ধরে পরীক্ষা, সঙ্গে সঙ্গে ফল</p>
            </a>
            <a href="#" class="group bg-white dark:bg-[#121B2B] p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                <span class="flex gap-1.5" aria-hidden="true">
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                </span>
                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">শিক্ষকের সহায়তা</h3>
                <p class="mt-1.5 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">আটকে গেলে প্রশ্ন করুন, উত্তর পাবেন</p>
            </a>
        </section>

        <!-- ============================================== -->
        <!-- ARCHIVE INDEX + ACADEMIC -->
        <!-- ============================================== -->
        <section class="grid lg:grid-cols-12 gap-10 lg:gap-14">

            <div class="lg:col-span-7">
                <div class="flex items-baseline justify-between mb-5">
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">প্রতিষ্ঠানভিত্তিক আর্কাইভ</h2>
                    <a href="#" class="text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">সব দেখুন</a>
                </div>

                <ul>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-t border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">বাংলাদেশ সিভিল সার্ভিস (বিসিএস)</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">৪৬টি পরীক্ষা</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-t border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">সরকারি কর্ম কমিশন (নন-ক্যাডার)</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">৩৮টি পরীক্ষা</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-t border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">প্রাথমিক শিক্ষা অধিদপ্তর</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">২৯টি পরীক্ষা</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-t border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">বাংলাদেশ ব্যাংক ও সমন্বিত ব্যাংক</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">৫২টি পরীক্ষা</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-t border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">মন্ত্রিপরিষদ ও জনপ্রশাসন মন্ত্রণালয়</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">২৪টি পরীক্ষা</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-baseline justify-between gap-6 px-1 py-4 border-y border-slate-200 dark:border-slate-800 hover:pl-4 hover:bg-slate-50 dark:hover:bg-[#121B2B] transition-all">
                            <span class="text-[15px] font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400">এনটিআরসিএ (বেসরকারি শিক্ষক নিবন্ধন)</span>
                            <span class="shrink-0 text-xs text-slate-500 dark:text-slate-400 tabular-nums">১৯টি পরীক্ষা</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="lg:col-span-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-5">একাডেমিক ও ভর্তি</h2>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">এসএসসি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">বোর্ড প্রশ্ন ও অধ্যায়ভিত্তিক টেস্ট</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">এইচএসসি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">সব বোর্ডের বিগত প্রশ্ন সমাধান</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">বিশ্ববিদ্যালয় ভর্তি</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">ঢাবি, রাবি, চবি ও গুচ্ছ</p>
                    </a>
                    <a href="#" class="p-5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">মেডিকেল ও বুয়েট</h3>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400 leading-relaxed">বিগত বছরের প্রশ্ন ও মডেল টেস্ট</p>
                    </a>
                </div>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- RECENT SOLUTIONS — answer-script slips -->
        <!-- ============================================== -->
        <section>
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">সদ্য যুক্ত সমাধান</h2>
                <a href="#" class="text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">সব সমাধান</a>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <a href="#" class="group flex items-stretch rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] overflow-hidden hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                    <div class="flex flex-col justify-center gap-2.5 px-3.5 bg-slate-50 dark:bg-[#0B1120] border-r border-slate-200 dark:border-slate-800" aria-hidden="true">
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mb-2.5">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">মন্ত্রিপরিষদ বিভাগ</span>
                            <span>২৮ আগস্ট, ২০২৬</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-slate-900 dark:text-white leading-[1.6] group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            কম্পিউটার অপারেটর পদের প্রশ্ন ও সমাধান
                        </h3>
                        <p class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-[13px] text-slate-500 dark:text-slate-400">
                            ৬৯টি এমসিকিউ, প্রতিটির ব্যাখ্যাসহ
                        </p>
                    </div>
                </a>

                <a href="#" class="group flex items-stretch rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#121B2B] overflow-hidden hover:border-emerald-500 dark:hover:border-emerald-500/60 transition-colors">
                    <div class="flex flex-col justify-center gap-2.5 px-3.5 bg-slate-50 dark:bg-[#0B1120] border-r border-slate-200 dark:border-slate-800" aria-hidden="true">
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-emerald-500 bg-emerald-500"></span>
                        <span class="w-2.5 h-2.5 rounded-full border-2 border-slate-300 dark:border-slate-700"></span>
                    </div>
                    <div class="flex-1 p-5">
                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mb-2.5">
                            <span class="font-semibold text-slate-700 dark:text-slate-300">জনপ্রশাসন মন্ত্রণালয়</span>
                            <span>০২ জুলাই, ২০২৬</span>
                        </div>
                        <h3 class="text-[17px] font-bold text-slate-900 dark:text-white leading-[1.6] group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            ব্যক্তিগত কর্মকর্তা পদের প্রশ্ন ও সমাধান
                        </h3>
                        <p class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-[13px] text-slate-500 dark:text-slate-400">
                            ১০০টি এমসিকিউ, প্রতিটির ব্যাখ্যাসহ
                        </p>
                    </div>
                </a>
            </div>
        </section>

        <!-- ============================================== -->
        <!-- CIRCULARS — notice board rows -->
        <!-- ============================================== -->
        <section>
            <div class="flex items-baseline justify-between mb-5">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">চলমান নিয়োগ বিজ্ঞপ্তি</h2>
                <a href="#" class="text-[13px] font-bold text-slate-900 dark:text-white border-b-2 border-emerald-500 pb-0.5">সব বিজ্ঞপ্তি</a>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-800">

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-rose-500">
                    <div>
                        <span class="text-[13px] font-bold text-rose-600 dark:text-rose-400">আজ শেষ</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">১৮ সেপ্টেম্বর</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">খাদ্য অধিদপ্তর — উপ-খাদ্য পরিদর্শক</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">৪১০টি পদ। স্নাতক পাস প্রার্থীরা অনলাইনে আবেদন করতে পারবেন।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-transparent">
                    <div>
                        <span class="text-[13px] font-bold text-slate-900 dark:text-slate-200">৪ দিন বাকি</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">২২ সেপ্টেম্বর</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">বাংলাদেশ রেলওয়ে — ওয়েম্যান</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">১৩৮৫টি পদ। অষ্টম শ্রেণি পাস হলেই আবেদন করা যাবে।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

                <article class="grid gap-3 md:grid-cols-[8.5rem_1fr_auto] md:items-center md:gap-6 py-5 pl-4 border-b border-slate-200 dark:border-slate-800 border-l-[3px] border-l-transparent">
                    <div>
                        <span class="text-[13px] font-bold text-slate-900 dark:text-slate-200">১০ দিন বাকি</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400 mt-0.5">২৮ সেপ্টেম্বর</span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">বাংলাদেশ ব্যাংক — অফিসার (জেনারেল)</h3>
                        <p class="mt-1 text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed">২৫০টি পদ। প্রিলিমিনারি পরীক্ষা ডিসেম্বরে হওয়ার সম্ভাবনা।</p>
                    </div>
                    <a href="#" class="justify-self-start md:justify-self-end whitespace-nowrap px-4 py-2 rounded-lg text-[13px] font-bold text-white bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 transition-colors">আবেদন করুন</a>
                </article>

            </div>
        </section>

    </div>

@endsection

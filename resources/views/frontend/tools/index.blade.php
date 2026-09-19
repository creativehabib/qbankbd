@php
$title = 'ডিজিটাল টুলস হাব | Digital Career Tools';
$description = 'সরকারি ও বেসরকারি চাকরি প্রার্থীদের জন্য সম্পূর্ণ ফ্রি ও নিরাপদ ডিজিটাল টুলস: ৯ম পে স্কেল ক্যালকুলেটর, টাইপিং টেস্ট, সিভি মেকার, জব ট্র্যাকার, ছবি ও স্বাক্ষর রিসাইজার, আবেদনপত্র মেকার, বয়স ক্যালকুলেটর, নেগেティブ মার্কিং ক্যালকুলেটর ও পিডিএফ স্প্লিটার।';
@endphp

@extends('layouts.frontend')

@section('title', $title)
@section('description', $description)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6 space-y-6">

        <!-- Compact Page Header (Cleaned up extra links) -->
        <div class="bg-gradient-to-r from-emerald-500/10 via-teal-500/10 to-indigo-500/10 rounded-2xl p-5 sm:p-6 border border-emerald-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-['SolaimanLipi']">
                        স্মার্ট প্রস্তুতি ও ডিজিটাল টুলস হাব
                    </h1>
                    <span class="inline-flex px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">
                    ১০টি স্মার্ট টুল
                </span>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-3xl leading-relaxed font-['SolaimanLipi']">
                    ৯ম পে স্কেল ক্যালকুলেটর, টাইপিং টেস্ট, সিভি মেকার, জব ট্র্যাকার, ছবি ও স্বাক্ষর রিসাইজার, আবেদনপত্র মেকার, বয়স ক্যালকুলেটর, নেগেটিভ মার্কিং ক্যালকুলেটর ও পিডিএফ স্প্লিটার—১০০% ফ্রি ও ব্রাউজার বেসড।
                </p>
            </div>
        </div>

        <!-- Category Filter Bar -->
        <div class="space-y-2 font-['SolaimanLipi']">
            <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-bold">
            <span class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                </svg>
                <span>ক্যাটাগরি অনুযায়ী টুলস:</span>
            </span>
                <div class="flex items-center gap-2">
                <span class="text-[11px] text-slate-400 dark:text-slate-500 sm:hidden flex items-center gap-1">
                    <span>ডানে স্ক্রল করুন</span>
                    <svg class="w-3.5 h-3.5 text-emerald-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold hidden sm:inline flex items-center gap-1.5">
                    <span>🔒</span> ১০০% ব্রাউজার প্রাইভেসি (জিরো সার্ভার আপলোড)
                </span>
                </div>
            </div>

            <div class="relative">
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar scrollbar-none py-1 sm:flex-wrap" id="category-filter-group">
                    <button type="button" data-cat="all" class="cat-pill active shrink-0 whitespace-nowrap px-4 py-2.5 rounded-xl text-xs font-bold transition-all bg-emerald-600 text-white shadow-sm border border-emerald-600">
                        সকল টুলস (১০)
                    </button>
                    <button type="button" data-cat="application" class="cat-pill shrink-0 whitespace-nowrap px-4 py-2.5 rounded-xl text-xs font-bold transition-all hover:border-emerald-500 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                        📝 আবেদন ও ক্যারিয়ার
                    </button>
                    <button type="button" data-cat="calculation" class="cat-pill shrink-0 whitespace-nowrap px-4 py-2.5 rounded-xl text-xs font-bold transition-all hover:border-emerald-500 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                        🧮 পরীক্ষা ও ক্যালকুলেশন
                    </button>
                    <button type="button" data-cat="utility" class="cat-pill shrink-0 whitespace-nowrap px-4 py-2.5 rounded-xl text-xs font-bold transition-all hover:border-emerald-500 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">
                        🛠️ ফাইল ইউটিলিটি
                    </button>
                </div>
                <!-- Mobile subtle edge fade hint -->
                <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white dark:from-slate-900 to-transparent sm:hidden"></div>
            </div>
        </div>

        <!-- 10 Tools Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tools-grid-container">

            <!-- Tool 1: 9th Pay Scale Calculator 2026 -->
            <a href="{{ route('tools.payscale_calculate') }}" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border-2 border-emerald-500/80 dark:border-emerald-500/60 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="calculation">
                <div class="absolute -top-3 right-6 px-3 py-1 rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-[10px] uppercase tracking-wider shadow-sm flex items-center gap-1">
                    <span>🔥</span>
                    <span>নতুন ও বহুল প্রতীক্ষিত</span>
                </div>

                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        💰
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-emerald-600 transition-colors font-['SolaimanLipi']">
                                ৯ম পে স্কেল ক্যালকুলেটর ২০২৬
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-300 font-['SolaimanLipi']">
                            ১ম-২০তম গ্রেড
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            প্রস্তাবিত ৯ম জাতীয় বেতন স্কেলের খসড়া কাঠামো অনুযায়ী ১ থেকে ২০তম গ্রেডের বর্তমান ও নতুন মূল বেতন, ভাতাসমূহ এবং ৪ ধাপের বাস্তবায়ন হিসাব করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১ম থেকে ২০তম গ্রেডের সকল ধাপের (Steps) নিখুঁত বেতন ম্যাপিং</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">বাড়ি ভাড়া (এলাকাভিত্তিক), চিকিৎসা, শিক্ষা, টিফিন ও যাতায়াত ভাতা</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">৪ ধাপের (২০২৬-২০২৮) সম্ভাব্য বাস্তবায়ন ও ইনক্রিমেন্ট ট্র্যাকার</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">⚡ লাইভ ইনস্ট্যান্ট হিসাব</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">📋 খসড়া প্রস্তাবনা ভিত্তিক</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-emerald-600 group-hover:bg-emerald-700 text-white font-bold text-sm inline-flex items-center justify-center gap-2 transition-all shadow-md shadow-emerald-600/20 font-['SolaimanLipi']">
                    <span>পে স্কেল হিসাব করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 2: Online Typing Test -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-emerald-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="calculation">
                <div class="absolute -top-3 right-6 px-3 py-1 rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-[10px] uppercase tracking-wider shadow-sm">
                    ⭐ সর্বাধিক জনপ্রিয়
                </div>

                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/80 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        ⌨️
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-emerald-600 transition-colors font-['SolaimanLipi']">
                                অনলাইন টাইপিং টেস্ট
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 font-['SolaimanLipi']">
                            ১১-২০তম গ্রেড
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            সরকারি চাকরির কম্পিউটার ব্যবহারিক পরীক্ষার জন্য আদর্শ প্ল্যাটফর্ম। ইন-বিল্ট অভ্র ও বিজয় কিবোর্ডে কোনো সফটওয়্যার ছাড়াই টাইপ প্র্যাকটিস করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">অভ্র ফোনেটিক, বিজয় (UniJoy) ও ইংরেজি মোড</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">লাইভ WPM, CPM, নিখুঁততার হার (%) ও ভুল কাউন্ট</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সরকারি চাকরির মানদণ্ডে তাৎক্ষণিক ফলাফল ও গ্রেড</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🇧🇩 12টি বাংলা প্যাসেজ</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🇬🇧 12টি ইংরেজি প্যাসেজ</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-emerald-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>টাইপিং টেস্ট শুরু করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 3: Professional CV Maker -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-purple-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="application">
                <div class="absolute -top-3 right-6 px-3 py-1 rounded-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-black text-[10px] uppercase tracking-wider shadow-sm">
                    ✨ প্রিমিয়াম ফ্রি
                </div>

                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 dark:bg-purple-950/80 text-purple-600 dark:text-purple-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        📄
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-purple-600 transition-colors font-['SolaimanLipi']">
                                প্রফেশনাল সিভি মেকার
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-800 dark:bg-purple-950 dark:text-purple-300 font-mono">
                            CV Maker
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            সরকারি চাকরি, ব্যাংক ও কর্পোরেট সেক্টরের উপযোগী আধুনিক সিভি তৈরি করুন। ১০০% ব্রাউজার বেসড লাইভ A4 প্রিভিউ ও ফ্রি ডাউনলোড।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">৪টি স্ট্যান্ডার্ড টেমপ্লেট ও ৬টি প্রফেশনাল কালার থিম</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১-ক্লিকে A4 পিডিএফ প্রিন্ট ও হাই-রেজ ছবি ডাউনলোড</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-purple-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সরকারি ও ব্যাংক চাকরির পূর্ণাঙ্গ তথ্য ও রেফারেন্স কাঠামো</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🔒 ১০০% প্রাইভেসি</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">⚡ A4 লাইভ স্কেলিং</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-purple-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>সিভি তৈরি শুরু করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 4: Job Application Tracker -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-indigo-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="application">
                <div class="absolute -top-3 right-6 px-3 py-1 rounded-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-black text-[10px] uppercase tracking-wider shadow-sm">
                    📋 পার্সোনাল ড্যাশবোর্ড
                </div>

                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        📋
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors font-['SolaimanLipi']">
                                জব অ্যাপ্লিকেশন ট্র্যাকার
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-100 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300 font-mono">
                            Tracker
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            আবেদনের শেষ তারিখ, ফি পরিশোধের অবস্থা, ইউজার আইডি, পাসওয়ার্ড ও পরীক্ষার তারিখ এক জায়গায় সুসংগঠিত রাখুন। ১০০% ব্রাউজারে সুরক্ষিত।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">কেপিআই কার্ড: মোট আবেদন, ফি বাকি, আসন্ন পরীক্ষা ও ভাইভা</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সম্পূর্ণ ব্যাকআপ এক্সপোর্ট (.json) ও অন্য ডিভাইসে ইমপোর্ট সুবিধা</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সার্চ বার ও ক্যাটাগরি ফিল্টারিং ও ১-ক্লিকে রিপোর্ট প্রিন্ট</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🔒 লোকাল মেমোরি</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">💾 ব্যাকআপ ও রিস্টোর</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-indigo-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>ড্যাশবোর্ড ট্র্যাকার ওপেন করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 5: Photo & Signature Resizer -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-blue-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="application">
                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        🖼️
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors font-['SolaimanLipi']">
                                ছবি ও স্বাক্ষর রিসাইজার
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-mono">
                            ৩০০x৩০০
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            টেলিটক ও বিভিন্ন চাকরির আবেদনের জন্য ছবি (৩০০x৩০০ px, সর্বোচ্চ ১০০ KB) ও স্বাক্ষর (৩০০x৮০ px, সর্বোচ্চ ৬০ KB) মাপমতো রিসাইজ করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">টেলিটক মানদণ্ডে স্বয়ংক্রিয় প্রিসেট ও সাইজ কম্প্রেশন</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">ফটো ক্রপ, জুম ও রোটেট করার লাইভ প্রিভিউ এডিটর</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১০০% নিরাপদ: ছবি আপনার ডিভাইস থেকে সার্ভারে আপলোড হয় না</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">📸 ১০০ KB</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">✍️ ৬০ KB</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-blue-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>ছবি ও স্বাক্ষর রিসাইজ করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 6: Official Application Maker -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-teal-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="application">
                <div class="absolute -top-3 right-6 px-3 py-1 rounded-full bg-gradient-to-r from-teal-600 to-emerald-600 text-white font-black text-[10px] uppercase tracking-wider shadow-sm">
                    ✨ নতুন ফিচার
                </div>

                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-950/80 text-teal-600 dark:text-teal-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        📝
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-teal-600 transition-colors font-['SolaimanLipi']">
                                আবেদনপত্র মেকার
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-100 text-teal-800 dark:bg-teal-950 dark:text-teal-300 font-mono">
                            A4 Letter
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            নৈমিত্তিক ছুটি (CL), অর্জিত ছুটি, মাতৃত্বকালীন ছুটি, মেডিকেল ছুটি, পাসপোর্ট/ভ্রমণের NOC, বদলি ও পদত্যাগপত্রের মানসম্মত সরকারি দরখাস্ত তৈরি করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-teal-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১০টি পূর্বনির্ধারিত স্ট্যান্ডার্ড সরকারি ও অফিস টেমপ্লেট</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-teal-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১-ক্লিকে A4 সাইজ পিডিএফ প্রিন্ট ও PNG ছবি ডাউনলোড</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-teal-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">বাংলাদেশ সচিবালয় নির্দেশিকা অনুযায়ী নিখুঁত বাংলা ফরম্যাটিং</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">📄 A4 ফরম্যাট</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🔒 ১০০% প্রাইভেসি</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-teal-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>দরখাস্ত তৈরি করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 7: Govt Job Age Calculator -->
            <a href="{{ route('tools.age_calculator') }}" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-amber-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="application">
                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        ⏳
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-amber-600 transition-colors font-['SolaimanLipi']">
                                সরকারি চাকরির বয়স ক্যালকুলেটর
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 font-['SolaimanLipi']">
                            ৩২ বছর
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            সর্বশেষ সরকারি গেজেট (সর্বোচ্চ ৩২ বছর) ও মুক্তিযোদ্ধা/প্রতিবন্ধী কোটা অনুযায়ী নির্ধারিত তারিখে আপনার সঠিক বয়স (বছর, মাস, দিন) নির্ণয় করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">বছর, মাস, দিন ও মোট দিনের বিস্তারিত নির্ভুল হিসাব</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সাধারণ (১৮-৩২), বিসিএস ও কোটার সর্বশেষ গেজেট মানদণ্ড</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">পরবর্তী জন্মদিনের লাইভ কাউন্টডাউন ও ফলাফল কপি</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🎯 গেজেট স্ট্যান্ডার্ড</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">⚡ ইনস্ট্যান্ট রেজাল্ট</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-amber-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>বয়স গণনা করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 8: Negative Marking Calculator -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-rose-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="calculation">
                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-950/80 text-rose-600 dark:text-rose-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        🎯
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-rose-600 transition-colors font-['SolaimanLipi']">
                                নেগেটিভ মার্কিং ক্যালকুলেটর
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300 font-mono">
                            Calculator
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            বিসিএস, প্রাথমিক শিক্ষক ও ব্যাংক পরীক্ষায় সঠিক ও ভুল উত্তরের সংখ্যা দিয়ে দশমিক পয়েন্টসহ নেট প্রাপ্ত নম্বর ও পার্সেন্টেজ হিসাব করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">বিসিএস (০.৫০), প্রাথমিক (০.২৫) ও ব্যাংক (০.২৫) প্রিসেট</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">তাৎক্ষণিক প্রাপ্ত নম্বর, অর্জিত শতকরা (%) ও একুরেসি রেট</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">ফলাফল স্কোরকার্ড ক্লিপবোর্ডে কপি ও সরাসরি প্রিন্ট সুবিধা</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">⚡ রিয়েল-টাইম হিসাব</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🎯 প্রিসেট বাটন</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-rose-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>নম্বর হিসাব করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 9: PDF Page Extractor & Splitter -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-blue-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="utility">
                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        📑
                    </div>

                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors font-['SolaimanLipi']">
                                পিডিএফ পেজ এক্সট্রাক্টর
                            </h3>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-mono">
                            Preview Ready
                        </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            বড় কোনো পিডিএফ থেকে লাইভ পেজ প্রিভিউ দেখে শুধু প্রয়োজনীয় নির্দিষ্ট পৃষ্ঠাসমূহ আলাদা করে নতুন হালকা সাইজের পিডিএফ বানিয়ে সেভ করুন।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">প্রতিটি পৃষ্ঠার নন-ব্লকিং ভিজ্যুয়াল থাম্বনেইল প্রিভিউ</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">পেজ রেঞ্জ (1-3, 5) বা সরাসরি থাম্বনেইল কার্ডে ক্লিক করে নির্বাচন</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">১০০% নিরাপদ: ফাইল ডিভাইস থেকে সার্ভারে আপলোড হয় না</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">⚡ ইনস্ট্যান্ট স্প্লিট</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🔒 জিরো আপলোড</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-blue-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>পিডিএফ পেজ আলাদা করুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

            <!-- Tool 10: Previous Exam Trend Analysis -->
            <a href="#" class="tool-card relative group rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm hover:border-indigo-500/50 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer flex flex-col justify-between" data-category="calculation">
                <div class="p-6 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-950/80 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-3xl font-bold shadow-inner">
                        📊
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white group-hover:text-indigo-600 transition-colors font-['SolaimanLipi']">
                            বিগত পরীক্ষার ট্রেন্ড বিশ্লেষণ
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-2 leading-relaxed font-['SolaimanLipi']">
                            বিসিএস, প্রাথমিক শিক্ষক ও ব্যাংক পরীক্ষার প্রশ্নব্যাংক বিশ্লেষণ করে কোন বিষয়ের কোন অধ্যায় থেকে বেশি প্রশ্ন আসে তার বাস্তব পরিসংখ্যান।
                        </p>
                    </div>

                    <ul class="space-y-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-['SolaimanLipi']">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">বিষয় ও অধ্যায়-ভিত্তিক প্রশ্ন সংখ্যা ও ওয়েইটেজ</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">সর্বাধিক গুরুত্বপূর্ণ হাই-প্রায়োরিটি টপিক চিহ্নিতকরণ</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-indigo-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="leading-snug">পরীক্ষার বছর ও সংস্থাভিত্তিক ফিল্টারিং ফিল্টার</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-2 pt-2 text-[11px] font-bold text-slate-500 dark:text-slate-400 font-['SolaimanLipi']">
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">📈 ডাটা-চালিত প্রস্তুতি</span>
                        <span class="px-2.5 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800">🎯 বিগত ২০ বছরের প্রশ্ন</span>
                    </div>
                </div>

                <div class="px-6 pb-6 pt-4 border-t border-slate-100 dark:border-slate-800/60 mt-auto">
                <span class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-indigo-600 group-hover:text-white text-slate-800 dark:text-slate-200 font-bold text-sm inline-flex items-center justify-center gap-2 transition-all font-['SolaimanLipi']">
                    <span>ট্রেন্ড অ্যানালাইসিস দেখুন</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                </div>
            </a>

        </div>

    </div>
    @push('script')
        <script>
            function initToolTabs() {
                const filterButtons = document.querySelectorAll('.cat-pill');
                const toolCards = document.querySelectorAll('.tool-card');

                if (filterButtons.length === 0) return;

                filterButtons.forEach(button => {
                    // ডুপ্লিকেট ইভেন্ট এড়াতে আগের ইভেন্ট রিমুভ করার ব্যবস্থা
                    button.replaceWith(button.cloneNode(true));
                });

                // নতুন করে রিকনস্ট্রক্ট করা বাটনগুলোতে ইভেন্ট যুক্ত করা
                document.querySelectorAll('.cat-pill').forEach(button => {
                    button.addEventListener('click', function() {
                        const targetCategory = this.getAttribute('data-cat');

                        document.querySelectorAll('.cat-pill').forEach(btn => {
                            btn.classList.remove('active', 'bg-emerald-600', 'text-white', 'shadow-sm', 'border-emerald-600');
                            btn.classList.add('bg-white', 'dark:bg-slate-800', 'border-slate-200', 'dark:border-slate-700', 'text-slate-700', 'dark:text-slate-300', 'hover:border-emerald-500');
                        });

                        this.classList.remove('bg-white', 'dark:bg-slate-800', 'border-slate-200', 'dark:border-slate-700', 'text-slate-700', 'dark:text-slate-300', 'hover:border-emerald-500');
                        this.classList.add('active', 'bg-emerald-600', 'text-white', 'shadow-sm', 'border-emerald-600');

                        document.querySelectorAll('.tool-card').forEach(card => {
                            const cardCategory = card.getAttribute('data-category');

                            if (targetCategory === 'all' || targetCategory === cardCategory) {
                                card.style.display = '';
                                card.animate([
                                    { opacity: 0, transform: 'scale(0.95)' },
                                    { opacity: 1, transform: 'scale(1)' }
                                ], { duration: 300, easing: 'ease-out' });
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            }

            // প্রথম লোডের জন্য
            document.addEventListener('DOMContentLoaded', initToolTabs);

            // Turbo Drive এক পেজ থেকে অন্য পেজে গেলে এটি রান করবে
            document.addEventListener('turbo:load', initToolTabs);
        </script>
    @endpush
@endsection

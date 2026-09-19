@php
    $title = '৯ম পে স্কেল ক্যালকুলেটর ২০২৬ - নতুন জাতীয় বেতন স্কেল ও ভাতাসমূহ হিসাব';
    $description = 'জাতীয় বেতনস্কেল ২০২৬ (৯ম পে স্কেল) ক্যালকুলেটর। ১ম থেকে ২০তম গ্রেডের ২০১৫ সালের মূল বেতন দিয়ে ২০২৬ সালের নতুন মূল বেতন, ৪টি ধাপের ইনক্রিমেন্ট, বাড়িভাড়া, চিকিৎসা, শিক্ষা ও অন্যান্য ভাতাসহ মোট বেতন তাৎক্ষণিক হিসাব করুন।';
    $shareUrl = urlencode(url()->current());
    $shareText = urlencode('৯ম পে স্কেল ২০২৬ (খসড়া প্রস্তাবনা)-এ আপনার নতুন বেতন ও ভাতা কত হবে, এখনই হিসাব করুন:');
@endphp
@extends('layouts.frontend')
@section('title', $title)
@section('description', $description)
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 sm:py-6 space-y-5 sm:space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
            <a href="/" class="hover:text-emerald-600 transition-colors">হোম</a>
            <span>›</span>
            <a href="/tools" class="hover:text-emerald-600 transition-colors">প্রস্তুতি টুলস</a>
            <span>›</span>
            <span class="text-slate-800 dark:text-slate-200 font-bold">জাতীয় বেতনস্কেল ২০২৬ ক্যালকুলেটর</span>
        </nav>

        <!-- Masthead -->
        <div class="flex items-start gap-3">
            <span class="hidden sm:block w-1 self-stretch rounded-full bg-emerald-500 shrink-0 mt-1"></span>
            <div class="flex-1 min-w-0 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-800 pb-5">
                <div class="space-y-1.5 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                            জাতীয় বেতনস্কেল ২০২৬ ক্যালকুলেটর
                        </h1>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold shrink-0">১ম থেকে ২০তম গ্রেড</span>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300 text-[11px] font-bold shrink-0">৯ম পে স্কেল (খসড়া)</span>
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                        প্রস্তাবিত ৯ম জাতীয় বেতন স্কেলের খসড়া কাঠামো অনুযায়ী আপনার বর্তমান মূল বেতন দিয়ে নতুন মূল বেতন, ৪ ধাপের বাস্তবায়ন ও ভাতাসমূহ হিসাব করুন।
                    </p>
                </div>

                <!-- Quick actions -->
                <div class="flex items-center gap-1.5 overflow-x-auto shrink-0 [&::-webkit-scrollbar]:hidden" style="scrollbar-width:none;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="shrink-0 px-3 py-2 rounded-xl bg-[#1877F2] hover:bg-[#166fe5] text-white font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors" title="ফেসবুকে শেয়ার করুন">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
                        <span class="hidden sm:inline">ফেসবুক</span>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="shrink-0 px-3 py-2 rounded-xl bg-[#25D366] hover:bg-[#20bd5a] text-white font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors" title="WhatsApp-এ শেয়ার করুন">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"></path></svg>
                        <span class="hidden sm:inline">WhatsApp</span>
                    </a>
                    <button type="button" onclick="shareCopyLink(this)" class="shrink-0 px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 text-slate-700 dark:text-slate-200 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer" title="ক্যালকুলেটর লিংক কপি করুন">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <span class="share-copy-text hidden sm:inline">লিংক কপি</span>
                    </button>
                    <button type="button" onclick="resetCalculator()" class="shrink-0 px-3 py-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors cursor-pointer" title="রিসেট করুন">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        <span class="hidden sm:inline">রিসেট</span>
                    </button>
                    <a href="/tools" class="shrink-0 px-3 py-2 rounded-xl bg-slate-900 dark:bg-emerald-600 hover:bg-emerald-600 dark:hover:bg-emerald-500 text-white font-bold text-xs inline-flex items-center justify-center gap-1.5 transition-colors">
                        <span>🧰</span>
                        <span class="hidden sm:inline">সকল টুলস</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Calculator Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 items-start">

            <!-- Calculator Form -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-4 sm:p-7 md:p-8 space-y-6">

                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div class="flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold shrink-0">💰</span>
                        <div>
                            <h2 class="text-base sm:text-xl font-extrabold text-slate-900 dark:text-white">
                                বেতন ও ভাতার তথ্য দিন
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                মাত্র ৩টি সহজ ধাপে আপনার নতুন পে স্কেল হিসাব করুন
                            </p>
                        </div>
                    </div>

                    <button type="button" onclick="resetCalculator()" class="text-xs text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 flex items-center gap-1 px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors cursor-pointer" title="সবকিছু রিসেট করুন">
                        <span>🔄</span>
                        <span class="font-bold">রিসেট</span>
                    </button>
                </div>

                <form id="salaryForm" onsubmit="event.preventDefault(); calculateSalaryPhases();" class="space-y-5">

                    <!-- Step 1: Grade Selection -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="grade" class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">১</span>
                                <span>আপনার চাকরির গ্রেড নির্বাচন করুন <span class="text-rose-500">*</span></span>
                            </label>
                            <span class="text-[11px] text-slate-400 font-semibold hidden sm:inline">১ম - ২০তম গ্রেড</span>
                        </div>

                        <!-- Quick Grade Chips -->
                        <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar scrollbar-none py-1">
                            <span class="text-[11px] font-bold text-slate-400 shrink-0">জনপ্রিয়:</span>
                            <button type="button" onclick="selectQuickGrade(20, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">২০তম</button>
                            <button type="button" onclick="selectQuickGrade(16, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">১৬তম</button>
                            <button type="button" onclick="selectQuickGrade(13, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">১৩তম</button>
                            <button type="button" onclick="selectQuickGrade(11, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">১১তম</button>
                            <button type="button" onclick="selectQuickGrade(10, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">১০ম</button>
                            <button type="button" onclick="selectQuickGrade(9, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">৯ম (বিসিএস)</button>
                            <button type="button" onclick="selectQuickGrade(1, this)" class="quick-grade-btn shrink-0 px-2.5 py-1 rounded-lg hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 font-bold transition-colors text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">১ম</button>
                        </div>

                        <select id="grade" onchange="onGradeChange()" class="w-full bg-slate-50 dark:bg-slate-800/90 border-2 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-base sm:text-sm font-bold rounded-xl p-3.5 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all cursor-pointer" required>
                            <option value="" disabled selected>গ্রেড নির্বাচন করুন (১ম থেকে ২০তম)</option>
                            <option value="1">গ্রেড ১ (সচিব/সমমান)</option><option value="2">গ্রেড ২</option><option value="3">গ্রেড ৩</option><option value="4">গ্রেড ৪</option><option value="5">গ্রেড ৫</option><option value="6">গ্রেড ৬</option><option value="7">গ্রেড ৭</option><option value="8">গ্রেড ৮</option><option value="9">গ্রেড ৯ (বিসিএস/১ম শ্রেণি)</option><option value="10">গ্রেড ১০ (২য় শ্রেণি)</option><option value="11">গ্রেড ১১</option><option value="12">গ্রেড ১২</option><option value="13">গ্রেড ১৩</option><option value="14">গ্রেড ১৪</option><option value="15">গ্রেড ১৫</option><option value="16">গ্রেড ১৬</option><option value="17">গ্রেড ১৭</option><option value="18">গ্রেড ১৮</option><option value="19">গ্রেড ১৯</option><option value="20">গ্রেড ২০</option>
                        </select>
                    </div>

                    <!-- Step 2: 2015 Basic Pay Step -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label for="oldBasicPay" class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-1.5">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">২</span>
                                <span>বর্তমান মূল বেতন বা ধাপ (২০১৫ স্কেল) <span class="text-rose-500">*</span></span>
                            </label>
                            <span id="stepHelpNotice" class="text-[11px] text-emerald-600 dark:text-emerald-400 font-bold">সার্ভিস বুক বা পে-স্লিপের ধাপ</span>
                        </div>

                        <select id="oldBasicPay" onchange="calculateNewBasic()" class="w-full bg-slate-50 dark:bg-slate-800/90 border-2 border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white text-base sm:text-sm font-bold rounded-xl p-3.5 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed" required disabled>
                            <option value="" disabled selected>👈 প্রথমে ওপরের গ্রেড নির্বাচন করুন</option>
                        </select>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-normal">
                            আপনার বর্তমান মূল বেতন সিলেক্ট করলেই নিচে ২০২৬ সালের নতুন মূল বেতন তাৎক্ষণিক হিসাব হবে।
                        </p>
                    </div>

                    <!-- Instant preview: unified stat strip -->
                    <div class="rounded-2xl border-2 border-emerald-300 dark:border-emerald-700/60 bg-emerald-50/50 dark:bg-emerald-950/20 p-4 sm:p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm font-bold text-emerald-800 dark:text-emerald-300 flex items-center gap-1.5">
                                <span>✨</span>
                                <span>নির্ধারিত নতুন মূল বেতন (২০২৬ স্কেল)</span>
                            </span>
                            <span id="scaleRatioBadge" class="text-[10px] sm:text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-600 text-white hidden">
                                ১০০% নিশ্চিত বৃদ্ধি
                            </span>
                        </div>

                        <div class="grid grid-cols-3 divide-x divide-emerald-200 dark:divide-emerald-800/70 border-t border-emerald-200 dark:border-emerald-800/70 pt-3 text-center">
                            <div class="px-1">
                                <span class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 block font-semibold">পূর্বের বেতন (২০১৫)</span>
                                <span id="previewOldBasic" class="text-sm sm:text-base font-extrabold text-slate-700 dark:text-slate-200 block mt-1">৳০</span>
                            </div>
                            <div class="px-1">
                                <span class="text-[10px] sm:text-[11px] text-emerald-700 dark:text-emerald-400 block font-semibold">নতুন মূল বেতন (২০২৬)</span>
                                <span id="previewNewBasic" class="text-base sm:text-lg font-extrabold text-emerald-600 dark:text-emerald-400 block mt-1">৳০</span>
                            </div>
                            <div class="px-1">
                                <span class="text-[10px] sm:text-[11px] text-teal-700 dark:text-teal-400 block font-semibold">মূল বেতন বৃদ্ধি</span>
                                <span id="previewDiff" class="text-sm sm:text-base font-extrabold text-teal-600 dark:text-teal-400 block mt-1">৳০</span>
                            </div>
                        </div>
                        <input type="hidden" id="newBasicPayVal" value="">
                        <input type="hidden" id="newBasicPayDisplay" value="">
                    </div>

                    <!-- Step 3: Allowance calculation parameters -->
                    <div class="bg-slate-50/90 dark:bg-slate-800/50 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-700/70 space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700/80 pb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold text-xs shrink-0">৩</span>
                                <h3 class="font-bold text-xs sm:text-sm text-slate-800 dark:text-slate-200">
                                    ভাতা ও কর্মস্থল সংক্রান্ত তথ্য (ঐচ্ছিক)
                                </h3>
                            </div>
                            <span class="text-[11px] text-slate-400 font-medium">বাড়িভাড়া ও অন্যান্য</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
                            <div class="space-y-1">
                                <label for="area" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                    কর্মস্থলের এলাকা
                                </label>
                                <select id="area" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 p-3 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                                    <option value="dhaka">ঢাকা উত্তর ও দক্ষিণ সিটি কর্পোরেশন</option>
                                    <option value="other_city">অন্যান্য সিটি কর্পোরেশন, সাভার ও কক্সবাজার</option>
                                    <option value="others" selected>অন্যান্য জেলা ও উপজেলা সদর</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="children" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                    সন্তান সংখ্যা (শিক্ষা ভাতার জন্য)
                                </label>
                                <select id="children" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 p-3 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                                    <option value="0">নেই (০ জন)</option>
                                    <option value="1">১ জন সন্তান (৳৫০০)</option>
                                    <option value="2">২ জন বা ততোধিক সন্তান (৳১০০০)</option>
                                </select>
                            </div>

                            <div class="space-y-1 sm:col-span-2">
                                <label for="age" class="block text-xs font-bold text-slate-700 dark:text-slate-300">
                                    কর্মচারীর বয়স (চিকিৎসা ভাতার জন্য)
                                </label>
                                <select id="age" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-700 p-3 rounded-xl text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                                    <option value="under50">৫০ বছর বা তার কম (৳১৫০০)</option>
                                    <option value="over50">৫০ বছরের বেশি (৳২৫০০)</option>
                                </select>
                            </div>

                            <label for="cityTransport" class="flex items-center justify-between p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 cursor-pointer transition-colors select-none">
                                <div class="space-y-0.5 pr-2">
                                    <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 block">সিটি যাতায়াত ভাতা?</span>
                                    <span class="text-[10px] sm:text-[11px] text-slate-400 block">সরকারি পরিবহন না পেলে প্রযোজ্য</span>
                                </div>
                                <input type="checkbox" id="cityTransport" class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 dark:border-slate-600 shrink-0 cursor-pointer">
                            </label>

                            <label for="tiffinProvided" class="flex items-center justify-between p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:border-emerald-500 cursor-pointer transition-colors select-none">
                                <div class="space-y-0.5 pr-2">
                                    <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 block">অফিসে খাবার / লাঞ্চ পান?</span>
                                    <span class="text-[10px] sm:text-[11px] text-slate-400 block">টিক দিলে টিফিন ভাতা বাদ যাবে</span>
                                </div>
                                <input type="checkbox" id="tiffinProvided" class="w-5 h-5 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 dark:border-slate-600 shrink-0 cursor-pointer">
                            </label>
                        </div>
                    </div>

                    <button type="submit" id="calcBtn" class="w-full py-4 px-6 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-base sm:text-lg shadow-sm active:scale-[0.98] transition-all flex items-center justify-center gap-2.5 cursor-pointer">
                        <span class="text-xl">📊</span>
                        <span>৪টি ধাপের বিস্তারিত বেতন ও ভাতা হিসাব করুন</span>
                    </button>
                </form>
            </div>

            <!-- Right column -->
            <div class="lg:col-span-5 space-y-6">

                <!-- Dark stat panel -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-6 sm:p-7 rounded-2xl border border-slate-700/80 space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-700 pb-3">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">বেতন বৃদ্ধি প্রাক্কলন</span>
                        <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">২০১৫ ➔ ২০২৬</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-slate-300">পূর্বের মূল বেতন:</span>
                            <span id="sideOldBasic" class="font-bold text-base sm:text-lg text-white">৳ ০</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-slate-300">নতুন মূল বেতন:</span>
                            <span id="sideNewBasic" class="font-extrabold text-lg sm:text-xl text-emerald-400">৳ ০</span>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-slate-700">
                            <span class="text-xs sm:text-sm text-emerald-200 font-bold">মোট মূল বেতন বৃদ্ধি:</span>
                            <span id="sideDiff" class="font-extrabold text-base sm:text-lg text-emerald-300">৳ ০</span>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-white/5 border border-white/10 text-xs text-slate-300 leading-relaxed">
                        💡 <strong>জরুরি তথ্য:</strong> প্রস্তাবিত পে স্কেলে ১ম থেকে ২০তম গ্রেডের কর্মচারীদের জন্য ধাপে ধাপে ১০০% বৃদ্ধি সমন্বিত হবে এবং চূড়ান্ত ধাপে বাড়িভাড়াসহ সকল ভাতা নতুন স্কেলে প্রযোজ্য হবে।
                    </div>
                </div>

                <!-- 4-phase timeline -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                    <h3 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🗓️</span>
                        <span>বাস্তবায়নের ৪টি পর্যায়কাল</span>
                    </h3>
                    <ul class="relative pl-7 space-y-4 before:content-[''] before:absolute before:left-[11px] before:top-1 before:bottom-1 before:w-px before:bg-slate-200 dark:before:bg-slate-700">
                        <li class="relative">
                            <span class="absolute -left-7 top-0 w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[10px]">১</span>
                            <div class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-slate-800 dark:text-slate-100">১ম ধাপ (১ জুলাই ২০২৬):</strong> গ্রেড ১-৯ এ ৪০% এবং গ্রেড ১০-২০ এ ৫০% বর্ধিত বেতন।</div>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-7 top-0 w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[10px]">২</span>
                            <div class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-slate-800 dark:text-slate-100">২য় ধাপ (১ জানুয়ারি ২০২৭):</strong> গ্রেড ১-৯ এ ৭০% এবং গ্রেড ১০-২০ এ ৭৫% বর্ধিত বেতন।</div>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-7 top-0 w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[10px]">৩</span>
                            <div class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed"><strong class="text-slate-800 dark:text-slate-100">৩য় ধাপ (১ জুলাই ২০২৭):</strong> সকল গ্রেডে নতুন মূল বেতনের ১০০% কার্যকর।</div>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-7 top-0 w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-[10px]">৪</span>
                            <div class="text-xs text-slate-700 dark:text-slate-200 leading-relaxed"><strong class="text-emerald-700 dark:text-emerald-400">চূড়ান্ত ধাপ (১ জানুয়ারি ২০২৮):</strong> নতুন মূল বেতনের ওপর নতুন হারে সকল ভাতা কার্যকর।</div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- Results Section -->
        <div id="result" class="space-y-6 pt-2 hidden">

            <!-- Summary -->
            <div class="bg-white dark:bg-slate-900 p-6 sm:p-7 rounded-2xl border-2 border-emerald-500/80 dark:border-emerald-500/60 space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">📊</span>
                        <h3 class="font-extrabold text-lg sm:text-xl text-slate-900 dark:text-white">
                            মূল বেতনের তুলনামূলক বিবরণী
                        </h3>
                    </div>
                    <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap">
                        <a href="https://api.whatsapp.com/send?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-[#25D366] hover:bg-[#20bd5a] text-white text-xs font-bold flex items-center gap-1.5 transition-colors" title="WhatsApp-এ শেয়ার করুন">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"></path></svg>
                            <span>WhatsApp</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-[#1877F2] hover:bg-[#166fe5] text-white text-xs font-bold flex items-center gap-1.5 transition-colors" title="ফেসবুকে শেয়ার করুন">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path></svg>
                            <span>ফেসবুক</span>
                        </a>
                        <button type="button" onclick="copySummary()" class="px-3.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs flex items-center gap-1.5 transition-colors">
                            <span>📋</span>
                            <span id="copyBtnText">সারাংশ কপি</span>
                        </button>
                        <button type="button" onclick="window.print()" class="px-3.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 font-bold text-xs flex items-center gap-1.5 transition-colors">
                            <span>🖨️</span>
                            <span>প্রিন্ট</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-3 divide-x divide-slate-200 dark:divide-slate-800 text-center">
                    <div class="px-2">
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-bold">পূর্বের মূল বেতন (২০১৫)</div>
                        <div class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-100 mt-1" id="resOldBasic">৳ ২০,৪৪০</div>
                    </div>
                    <div class="px-2">
                        <div class="text-xs text-emerald-700 dark:text-emerald-400 font-bold">নির্ধারিত নতুন মূল বেতন (২০২৬)</div>
                        <div class="font-extrabold text-xl sm:text-2xl text-emerald-600 dark:text-emerald-400 mt-1" id="resNewBasic">৳ ৩৭,১০০</div>
                    </div>
                    <div class="px-2">
                        <div class="text-xs text-teal-700 dark:text-teal-400 font-bold">মোট বেতন বৃদ্ধি (পার্থক্য)</div>
                        <div class="font-extrabold text-xl sm:text-2xl text-teal-600 dark:text-teal-400 mt-1" id="resDiff">+ ৳ ১৬,৬৬০</div>
                    </div>
                </div>
            </div>

            <div class="text-center pt-2">
                <h3 class="font-extrabold text-xl sm:text-2xl text-slate-900 dark:text-white flex items-center justify-center gap-2">
                    <span>🗓️</span>
                    <span>৪টি ধাপের বিস্তারিত বেতন ও ভাতাসমূহ</span>
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    প্রতিটি ধাপে আপনার একাউন্টে প্রতি মাসে জমাকৃত মূল বেতন, ভাতা ও মোট টাকার হিসাব
                </p>
            </div>

            <!-- 4-Phases Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

                <!-- Phase 1 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[11px] shrink-0">১</span>
                            <h4 class="font-extrabold text-slate-900 dark:text-white text-base">১ম পর্যায়</h4>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 ml-8">জুলাই ২০২৬ - ডিসে ২০২৬</p>

                        <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5 mb-1.5">
                                <span class="font-bold">মূল বেতন:</span>
                                <span id="p1Basic" class="font-extrabold text-slate-900 dark:text-white">৳ ২৮,৭৭০</span>
                            </div>
                            <div id="p1AllowancesList"><div class="text-[11px] space-y-1 mt-2 p-2.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-100 dark:border-slate-700/60"><div class="text-slate-500 dark:text-slate-400 mb-1 border-b border-slate-200 dark:border-slate-700 pb-1 font-bold">ভাতাসমূহ (২০১৫ হারে):</div><div class="flex justify-between"><span>বাড়িভাড়া (৫৫%):</span><span class="font-bold">৳ ১১,২৪২</span></div><div class="flex justify-between"><span>চিকিৎসা:</span><span class="font-bold">৳ ১,৫০০</span></div><div class="flex justify-between"><span>শিক্ষা ভাতা:</span><span class="font-bold">৳ ৫০০</span></div><div class="flex justify-between mt-1 pt-1 border-t border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-extrabold"><span>মোট ভাতা:</span><span>৳ ১৩,২৪২</span></div></div></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 font-bold mb-0.5">সর্বমোট বেতন (মাসিক):</div>
                        <div class="text-xl font-extrabold text-slate-900 dark:text-white" id="p1Gross">৳ ৪২,০১২</div>
                    </div>
                </div>

                <!-- Phase 2 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[11px] shrink-0">২</span>
                            <h4 class="font-extrabold text-slate-900 dark:text-white text-base">২য় পর্যায়</h4>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 ml-8">জানু ২০২৭ - জুন ২০২৭</p>

                        <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5 mb-1.5">
                                <span class="font-bold">মূল বেতন:</span>
                                <span id="p2Basic" class="font-extrabold text-slate-900 dark:text-white">৳ ৩২,৯৩৫</span>
                            </div>
                            <div id="p2AllowancesList"><div class="text-[11px] space-y-1 mt-2 p-2.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-100 dark:border-slate-700/60"><div class="text-slate-500 dark:text-slate-400 mb-1 border-b border-slate-200 dark:border-slate-700 pb-1 font-bold">ভাতাসমূহ (২০১৫ হারে):</div><div class="flex justify-between"><span>বাড়িভাড়া (৫৫%):</span><span class="font-bold">৳ ১১,২৪২</span></div><div class="flex justify-between"><span>চিকিৎসা:</span><span class="font-bold">৳ ১,৫০০</span></div><div class="flex justify-between"><span>শিক্ষা ভাতা:</span><span class="font-bold">৳ ৫০০</span></div><div class="flex justify-between mt-1 pt-1 border-t border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-extrabold"><span>মোট ভাতা:</span><span>৳ ১৩,২৪২</span></div></div></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 font-bold mb-0.5">সর্বমোট বেতন (মাসিক):</div>
                        <div class="text-xl font-extrabold text-slate-900 dark:text-white" id="p2Gross">৳ ৪৬,১৭৭</div>
                    </div>
                </div>

                <!-- Phase 3 -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-6 h-6 rounded-full border-2 border-slate-300 dark:border-slate-600 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-[11px] shrink-0">৩</span>
                            <h4 class="font-extrabold text-slate-900 dark:text-white text-base">৩য় পর্যায়</h4>
                        </div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-3 ml-8">জুলাই ২০২৭ - ডিসে ২০২৭</p>

                        <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-800 pb-1.5 mb-1.5">
                                <span class="font-bold">মূল বেতন (১০০%):</span>
                                <span id="p3Basic" class="font-extrabold text-slate-900 dark:text-white">৳ ৩৭,১০০</span>
                            </div>
                            <div id="p3AllowancesList"><div class="text-[11px] space-y-1 mt-2 p-2.5 bg-slate-50 dark:bg-slate-800/60 rounded-xl border border-slate-100 dark:border-slate-700/60"><div class="text-slate-500 dark:text-slate-400 mb-1 border-b border-slate-200 dark:border-slate-700 pb-1 font-bold">ভাতাসমূহ (২০১৫ হারে):</div><div class="flex justify-between"><span>বাড়িভাড়া (৫৫%):</span><span class="font-bold">৳ ১১,২৪২</span></div><div class="flex justify-between"><span>চিকিৎসা:</span><span class="font-bold">৳ ১,৫০০</span></div><div class="flex justify-between"><span>শিক্ষা ভাতা:</span><span class="font-bold">৳ ৫০০</span></div><div class="flex justify-between mt-1 pt-1 border-t border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-extrabold"><span>মোট ভাতা:</span><span>৳ ১৩,২৪২</span></div></div></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <div class="text-[11px] text-slate-500 dark:text-slate-400 font-bold mb-0.5">সর্বমোট বেতন (মাসিক):</div>
                        <div class="text-xl font-extrabold text-slate-900 dark:text-white" id="p3Gross">৳ ৫০,৩৪২</div>
                    </div>
                </div>

                <!-- Phase 4 - final, highlighted -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl border-2 border-emerald-500 p-5 flex flex-col justify-between relative">
                    <span class="absolute -top-2.5 right-4 bg-emerald-600 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">✨ নতুন ভাতাসহ পূর্ণাঙ্গ</span>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-6 h-6 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-[11px] shrink-0">৪</span>
                            <h4 class="font-extrabold text-emerald-700 dark:text-emerald-400 text-base">চূড়ান্ত ধাপ</h4>
                        </div>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-3 ml-8 font-semibold">১ জানু ২০২৮ থেকে চলমান</p>

                        <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                            <div class="flex justify-between border-b border-emerald-100 dark:border-emerald-900/50 pb-1.5 mb-1.5">
                                <span class="font-bold">মূল বেতন (১০০%):</span>
                                <span id="p4Basic" class="font-extrabold text-slate-900 dark:text-white">৳ ৩৭,১০০</span>
                            </div>
                            <div id="p4AllowancesList"><div class="text-[11px] space-y-1 mt-2 p-2.5 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-xl border border-emerald-200 dark:border-emerald-800/60"><div class="text-emerald-800 dark:text-emerald-300 mb-1 border-b border-emerald-200 dark:border-emerald-800/60 pb-1 font-bold">ভাতাসমূহ (২০২৮ নতুন হারে):</div><div class="flex justify-between"><span>নতুন বাড়িভাড়া (৫০%):</span><span class="font-bold">৳ ১৮,৫৫০</span></div><div class="flex justify-between"><span>নতুন চিকিৎসা:</span><span class="font-bold">৳ ৩,০০০</span></div><div class="flex justify-between"><span>মোবাইল ভাতা:</span><span class="font-bold">৳ ১৫০</span></div><div class="flex justify-between"><span>শিক্ষা ভাতা:</span><span class="font-bold">৳ ৫০০</span></div><div class="flex justify-between mt-1 pt-1 border-t border-emerald-300 dark:border-emerald-700 text-emerald-900 dark:text-emerald-200 font-extrabold"><span>নতুন মোট ভাতা:</span><span>৳ ২২,২০০</span></div></div></div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-t-2 border-emerald-500">
                        <div class="text-[11px] text-emerald-700 dark:text-emerald-400 font-bold mb-0.5">চূড়ান্ত সর্বমোট বেতন:</div>
                        <div class="text-xl font-extrabold text-emerald-600 dark:text-emerald-400" id="p4Gross">৳ ৫৯,৩০০</div>
                    </div>
                </div>

            </div>

            <div class="text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-800/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700/60 leading-relaxed">
                <strong class="text-slate-700 dark:text-slate-200">বিশেষ দ্রষ্টব্য:</strong> ৩১ ডিসেম্বর ২০২৭ পর্যন্ত সকল ভাতা ২০১৫ সালের প্রচলিত নিয়ম অনুযায়ী পুরাতন মূল বেতনের ওপর ভিত্তি করে প্রদর্শিত হয়েছে। ১ জানুয়ারি ২০২৮ থেকে নতুন স্কেলের মূল বেতনের ওপর প্রস্তাবিত প্রজ্ঞাপনের হারে সকল নতুন ভাতা হিসাব করা হয়েছে।
            </div>

        </div>

        <!-- SEO Content -->
        <div class="space-y-6 sm:space-y-8 pt-4">

            <!-- Grade comparison table -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-4">
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2">
                            <span>📋</span>
                            <span>১ম থেকে ২০তম গ্রেড: জাতীয় বেতন স্কেল ২০১৫ বনাম ২০২৬ প্রারম্ভিক বেতন</span>
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                            প্রতিটি গ্রেডের ২০১৫ স্কেলের শুরুর মূল বেতন এবং ২০২৬ স্কেলের প্রস্তাবিত শুরুর বেতনের তুলনা
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs sm:text-sm">
                        <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-300 font-bold border-b border-slate-200 dark:border-slate-700">
                            <th class="py-3 px-3 sm:px-4">গ্রেড</th>
                            <th class="py-3 px-3 sm:px-4">২০১৫ স্কেল (প্রারম্ভিক)</th>
                            <th class="py-3 px-3 sm:px-4">২০২৬ স্কেল (প্রস্তাবিত প্রারম্ভিক)</th>
                            <th class="py-3 px-3 sm:px-4">বৃদ্ধির পরিমাণ</th>
                            <th class="py-3 px-3 sm:px-4">শতকরা বৃদ্ধি</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 font-semibold"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১</td><td class="py-2.5 px-3 sm:px-4">৳ ৭৮,০০০ (নির্ধারিত)</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ১,৫৬,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৭৮,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 font-bold">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ২</td><td class="py-2.5 px-3 sm:px-4">৳ ৬৬,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ১,৩২,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৬৬,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৩</td><td class="py-2.5 px-3 sm:px-4">৳ ৫৬,৫০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ১,১৩,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৫৬,৫০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৪</td><td class="py-2.5 px-3 sm:px-4">৳ ৫০,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ১,০০,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৫০,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৫</td><td class="py-2.5 px-3 sm:px-4">৳ ৪৩,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ৮৬,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৪৩,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৬</td><td class="py-2.5 px-3 sm:px-4">৳ ৩৫,৫০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ৭১,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ৩৫,৫০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৭</td><td class="py-2.5 px-3 sm:px-4">৳ ২৯,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ৫৮,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ২৯,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৮</td><td class="py-2.5 px-3 sm:px-4">৳ ২৩,০০০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 dark:text-emerald-400 font-bold">৳ ৪৬,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ২৩,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 font-semibold text-emerald-800 dark:text-emerald-300 bg-emerald-50/40 dark:bg-emerald-950/20"><td class="py-2.5 px-3 sm:px-4">গ্রেড ৯ (বিসিএস)</td><td class="py-2.5 px-3 sm:px-4">৳ ২২,০০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ৪৪,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ২২,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 font-semibold"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৬,০০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ৩২,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৬,০০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১১</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,৫০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২৫,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,৫০০</td><td class="py-2.5 px-3 sm:px-4">১০০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১২</td><td class="py-2.5 px-3 sm:px-4">৳ ১১,৩০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২৪,৩০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৩,০০০</td><td class="py-2.5 px-3 sm:px-4">১১৫%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৩</td><td class="py-2.5 px-3 sm:px-4">৳ ১১,০০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২৪,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৩,০০০</td><td class="py-2.5 px-3 sm:px-4">১১৮%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৪</td><td class="py-2.5 px-3 sm:px-4">৳ ১০,২০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২৩,৫০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৩,৩০০</td><td class="py-2.5 px-3 sm:px-4">১৩০%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৫</td><td class="py-2.5 px-3 sm:px-4">৳ ৯,৭০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২২,৮০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১৩,১০০</td><td class="py-2.5 px-3 sm:px-4">১৩৫%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৬</td><td class="py-2.5 px-3 sm:px-4">৳ ৯,৩০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২১,৯০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,৬০০</td><td class="py-2.5 px-3 sm:px-4">১৩৫%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৭</td><td class="py-2.5 px-3 sm:px-4">৳ ৯,০০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২১,৪০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,৪০০</td><td class="py-2.5 px-3 sm:px-4">১৩৭%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৮</td><td class="py-2.5 px-3 sm:px-4">৳ ৮,৮০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২১,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,২০০</td><td class="py-2.5 px-3 sm:px-4">১৩৮%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40"><td class="py-2.5 px-3 sm:px-4">গ্রেড ১৯</td><td class="py-2.5 px-3 sm:px-4">৳ ৮,৫০০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২০,৫০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১২,০০০</td><td class="py-2.5 px-3 sm:px-4">১৪১%</td></tr>
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 font-semibold bg-emerald-50/30 dark:bg-emerald-950/20"><td class="py-2.5 px-3 sm:px-4">গ্রেড ২০</td><td class="py-2.5 px-3 sm:px-4">৳ ৮,২৫০</td><td class="py-2.5 px-3 sm:px-4 font-bold text-emerald-600 dark:text-emerald-400">৳ ২০,০০০</td><td class="py-2.5 px-3 sm:px-4">৳ ১১,৭৫০</td><td class="py-2.5 px-3 sm:px-4 text-emerald-600 font-bold">১৪২%</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Guide cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 space-y-4">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🏠</span>
                        <span>বাড়িভাড়া ভাতার নতুন কাঠামো ও হার</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        ২০২৮ সালের চূড়ান্ত ধাপে বাড়িভাড়া ভাতার ক্ষেত্রে পদমর্যাদা ও কর্মস্থলের ভৌগোলিক অবস্থান অনুযায়ী নতুন শতকরা হার প্রস্তাব করা হয়েছে:
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>১৬তম থেকে ২০তম গ্রেড:</strong> ঢাকা সিটিতে ৬০%, অন্যান্য সিটিতে ৫০% এবং অন্যান্য স্থানে ৪৫%।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>১০ম থেকে ১৫তম গ্রেড:</strong> ঢাকা সিটিতে ৫০%, অন্যান্য সিটিতে ৪০% এবং অন্যান্য স্থানে ৩৫%।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>৫ম থেকে ৯ম গ্রেড:</strong> ঢাকা সিটিতে ৪৫%, অন্যান্য সিটিতে ৩৫% এবং অন্যান্য স্থানে ৩০%।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>১ম থেকে ৪র্থ গ্রেড:</strong> ঢাকা সিটিতে ৪০%, অন্যান্য সিটিতে ৩০% এবং অন্যান্য স্থানে ২৫%।
                        </li>
                    </ul>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-7 space-y-4">
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <span>🏥</span>
                        <span>চিকিৎসা, শিক্ষা ও অন্যান্য ভাতা</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        প্রস্তাবিত বেতন স্কেলে জীবনযাত্রার ব্যয় বৃদ্ধির কথা বিবেচনা করে সকল ক্যাটাগরির ভাতায় ব্যাপক পরিবর্তন আনা হচ্ছে:
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600 dark:text-slate-300">
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>চিকিৎসা ভাতা:</strong> ৫০ বছর বা তার কম বয়সীদের জন্য ৩,০০০ টাকা এবং ৫০ বছরের বেশি বয়সীদের জন্য ৪,০০০ টাকা।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>শিক্ষা সহায়ক ভাতা:</strong> সন্তান প্রতি ৫০০ টাকা করে সর্বোচ্চ ২ সন্তানের জন্য ১,০০০ টাকা।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>টিফিন ও যাতায়াত ভাতা:</strong> ১১-২০তম গ্রেডের জন্য টিফিন ভাতা ৫০০ টাকা এবং সিটি কর্পোরেশনে যাতায়াত ভাতা ৬০০ টাকা।
                        </li>
                        <li class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-700/60">
                            <strong>মোবাইল ভাতা:</strong> ১ম থেকে ৫ম গ্রেড ৫০০ টাকা এবং অন্যান্য গ্রেড ১৫০ টাকা।
                        </li>
                    </ul>
                </div>

            </div>

            <!-- FAQ -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 space-y-4">
                <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <span>❓</span>
                    <span>৯ম পে স্কেল সম্পর্কিত সচরাচর জিজ্ঞাসা (FAQ)</span>
                </h2>

                <div class="space-y-3 pt-1">
                    <details class="group p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/70 dark:border-slate-700/70 cursor-pointer">
                        <summary class="font-bold text-sm text-slate-800 dark:text-slate-200 flex items-center justify-between">
                            <span>জাতীয় বেতন স্কেল ২০২৬ কীভাবে হিসাব করা হয়েছে?</span>
                            <span class="text-emerald-600 transition-transform group-open:rotate-180">▼</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-3 leading-relaxed border-t border-slate-200/60 dark:border-slate-700 pt-2.5">
                            ২০১৫ সালের মূল বেতনের ওপর ভিত্তি করে ২০২৬ সালের প্রস্তাবিত গ্রেড অনুযায়ী সমপরিমাণ বা নিকটবর্তী পরবর্তী ইনক্রিমেন্ট ধাপটি নির্ধারণ করা হয়েছে। এরপর গ্রেড ১-৯ এবং ১০-২০ এর নির্ধারিত শতকরা হারে ৪টি ধাপে মোট বৃদ্ধির অংক যোগ করা হয়েছে।
                        </p>
                    </details>

                    <details class="group p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/70 dark:border-slate-700/70 cursor-pointer">
                        <summary class="font-bold text-sm text-slate-800 dark:text-slate-200 flex items-center justify-between">
                            <span>পেনশনার ও অবসরপ্রাপ্ত কর্মকর্তাদের জন্য কি এটি প্রযোজ্য?</span>
                            <span class="text-emerald-600 transition-transform group-open:rotate-180">▼</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-3 leading-relaxed border-t border-slate-200/60 dark:border-slate-700 pt-2.5">
                            হ্যাঁ, নতুন পে স্কেল কার্যকর হলে অবসরপ্রাপ্ত সরকারি চাকরিজীবীদের পেনশন এবং আনুতোষিক (গ্র্যাচুইটি) নতুন বেতন স্কেলের মানদণ্ড অনুযায়ী আনুপাতিক হারে স্বয়ংক্রিয়ভাবে বৃদ্ধি পাবে।
                        </p>
                    </details>

                    <details class="group p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200/70 dark:border-slate-700/70 cursor-pointer" open>
                        <summary class="font-bold text-sm text-slate-800 dark:text-slate-200 flex items-center justify-between">
                            <span>সরকারি চূড়ান্ত গেজেটের সাথে এই হিসাবের কোনো অমিল হতে পারে কি?</span>
                            <span class="text-emerald-600 transition-transform group-open:rotate-180">▼</span>
                        </summary>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-3 leading-relaxed border-t border-slate-200/60 dark:border-slate-700 pt-2.5">
                            এই ক্যালকুলেটরটি পে স্কেল কমিশনের বিভিন্ন খসড়া সুপারিশ এবং বিগত জাতীয় বেতন স্কেল বাস্তবায়নের সূত্রের ওপর ভিত্তি করে তৈরি। অর্থ মন্ত্রণালয় কর্তৃক চূড়ান্ত গেজেট প্রজ্ঞাপন জারি করা হলে তার সাথে সামান্য তারতম্য হতে পারে, যা আমরা সাথে সাথে আপডেট করে দেব।
                        </p>
                    </details>
                </div>
            </div>

            <!-- Disclaimer -->
            <div class="p-5 sm:p-6 rounded-2xl bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/70 text-amber-900 dark:text-amber-200 space-y-2">
                <div class="flex items-start gap-3">
                    <span class="text-2xl shrink-0 mt-0.5">⚠️</span>
                    <div class="space-y-1">
                        <h4 class="font-bold text-sm sm:text-base text-amber-950 dark:text-amber-100">
                            তথ্যের নির্ভুলতা ও সতর্কতা বিজ্ঞপ্তি:
                        </h4>
                        <p class="text-xs sm:text-sm leading-relaxed text-amber-800 dark:text-amber-300">
                            এই ক্যালকুলেটরে প্রদর্শিত তথ্য ও হিসাবসমূহ প্রস্তাবিত ৯ম পে স্কেল সংক্রান্ত বিভিন্ন প্রাথমিক প্রতিবেদন, খসড়া সুপারিশ ও প্রচলিত সূত্রের ওপর ভিত্তি করে প্রাক্কলন করা হয়েছে। তথ্যে ভুল ত্রুটি থাকতে পারে, আমরা নিয়মিত সংশোধন করার চেষ্টা করছি। সরকারি চূড়ান্ত গেজেট বা প্রজ্ঞাপন প্রকাশের পর আমরা এটি আরও নিখুঁতভাবে হালনাগাদ করব। কোনো দাপ্তরিক, প্রশাসনিক বা আর্থিক সিদ্ধান্তের ক্ষেত্রে সরকারের চূড়ান্ত প্রজ্ঞাপন ও সংশ্লিষ্ট কর্তৃপক্ষের নির্দেশনাই মান্য হবে।
                        </p>
                    </div>
                </div>
            </div>

            <!-- Related Tools -->
            <div class="pt-4">
                <h3 class="font-bold text-sm text-slate-700 dark:text-slate-300 mb-3 flex items-center gap-2">
                    <span>🛠️</span>
                    <span>অন্যান্য সহায়ক ক্যারিয়ার টুলস</span>
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                    <a href="/tools/age-calculator" class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 transition-colors group flex flex-col justify-between">
                        <span class="text-xl mb-1">🎂</span>
                        <div>
                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-emerald-600">বয়স ক্যালকুলেটর</div>
                            <div class="text-[11px] text-slate-400">১৮-৩২ বছর যাচাই</div>
                        </div>
                    </a>
                    <a href="/tools/negative-marking-calculator" class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 transition-colors group flex flex-col justify-between">
                        <span class="text-xl mb-1">🎯</span>
                        <div>
                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-emerald-600">নেগেটিভ মার্কিং</div>
                            <div class="text-[11px] text-slate-400">বিসিএস ও প্রাথমিক</div>
                        </div>
                    </a>
                    <a href="/tools/cv-maker" class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 transition-colors group flex flex-col justify-between">
                        <span class="text-xl mb-1">📄</span>
                        <div>
                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-emerald-600">সিভি মেকার</div>
                            <div class="text-[11px] text-slate-400">ফ্রি পিডিএফ ডাউনলোড</div>
                        </div>
                    </a>
                    <a href="/tools/photo-resizer" class="p-3.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-emerald-500 transition-colors group flex flex-col justify-between">
                        <span class="text-xl mb-1">🖼️</span>
                        <div>
                            <div class="font-bold text-xs text-slate-800 dark:text-slate-200 group-hover:text-emerald-600">ছবি ও স্বাক্ষর রিসাইজার</div>
                            <div class="text-[11px] text-slate-400">৩০০x৩০০ ও ৩০০x৮০</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

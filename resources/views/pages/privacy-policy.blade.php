@php
    $generalSettings = \App\Support\SettingsStore::group('general');
    $brandingSettings = \App\Support\SettingsStore::group('branding');
    
    $siteName = $brandingSettings['app_name'] ?? 'প্রশ্নব্যাংক';
    $pageTitle = 'গোপনীয়তা নীতি - ' . $siteName;
@endphp
<!DOCTYPE html>
<html lang="bn" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#f5f3ee] text-slate-900 transition-colors duration-300 dark:bg-[#0d0f1a] dark:text-slate-100">

<header class="fixed inset-x-0 top-0 z-50 border-b border-sky-200/50 bg-[#f5f3ee]/90 backdrop-blur-lg dark:border-sky-700/30 dark:bg-[#0d0f1a]/90">
    <nav class="mx-auto flex h-17 w-full max-w-7xl items-center justify-between px-4 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-sky-600 dark:text-sky-400">
            <x-app-logo-icon />
        </a>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 hover:text-sky-600 dark:text-slate-300 dark:hover:text-sky-400">হোমপেজে ফিরে যান</a>
        </div>
    </nav>
</header>

<main class="pt-24 pb-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-sky-200/60 bg-white p-8 shadow-sm dark:border-sky-700/30 dark:bg-[#13172b] md:p-12">
            <h1 class="mb-2 text-3xl font-bold text-slate-900 dark:text-slate-100">গোপনীয়তা নীতি (Privacy Policy)</h1>
            <p class="mb-8 text-sm text-slate-500 dark:text-slate-400">সর্বশেষ আপডেট: {{ now()->format('d M, Y') }}</p>

            <div class="prose prose-slate max-w-none dark:prose-invert prose-headings:font-tiro prose-a:text-sky-600">
                <p><strong>{{ $siteName }}</strong>-এ আপনাকে স্বাগতম। আমরা আমাদের ব্যবহারকারীদের (শিক্ষার্থী, শিক্ষক, চাকরিপ্রার্থী ও অন্যান্য) ব্যক্তিগত তথ্যের সুরক্ষাকে সর্বোচ্চ গুরুত্ব দিয়ে থাকি। আপনি যখন আমাদের ওয়েবসাইট বা প্ল্যাটফর্ম ব্যবহার করেন, তখন আমরা কীভাবে আপনার তথ্য সংগ্রহ, ব্যবহার এবং সুরক্ষিত রাখি, তা এই নীতিমালায় বিস্তারিত বলা হয়েছে।</p>

                <h3>১. আমরা কী কী তথ্য সংগ্রহ করি?</h3>
                <p>আপনি যখন আমাদের প্ল্যাটফর্মে যুক্ত হন, তখন আমরা সাধারণত নিম্নলিখিত তথ্যগুলো সংগ্রহ করি:</p>
                <ul>
                    <li><strong>ব্যক্তিগত তথ্য:</strong> নাম, ইমেইল ঠিকানা, ফোন নম্বর (রেজিস্ট্রেশন বা প্রোফাইল তৈরি করার সময়)।</li>
                    <li><strong>একাডেমিক তথ্য:</strong> আপনার লক্ষ্য, শ্রেণি, প্রতিষ্ঠান বা আপনি যে চাকরির প্রস্তুতি নিচ্ছেন তার বিবরণ (সার্ভিস পারসোনালাইজ করার জন্য)।</li>
                    <li><strong>ব্যবহারিক তথ্য:</strong> আপনি কোন মডেল টেস্ট দিচ্ছেন, কত মার্কস পাচ্ছেন, কোন প্রশ্নগুলো বেশি পড়ছেন, আপনার আইপি (IP) অ্যাড্রেস এবং ব্রাউজারের ধরন।</li>
                </ul>

                <h3>২. আমরা কেন আপনার তথ্য সংগ্রহ করি?</h3>
                <p>আমরা সংগৃহীত তথ্যগুলো মূলত নিচের উদ্দেশ্যে ব্যবহার করে থাকি:</p>
                <ul>
                    <li>আপনাকে আমাদের প্ল্যাটফর্মে একটি নিরবচ্ছিন্ন এবং পারসোনালাইজড অভিজ্ঞতা দেওয়ার জন্য।</li>
                    <li>আপনার মডেল টেস্টের ফলাফল এবং লিডারবোর্ড র‍্যাংকিং তৈরি করার জন্য।</li>
                    <li>সিস্টেমের নিরাপত্তা নিশ্চিত করা এবং কোনো সন্দেহজনক বা স্প্যামিং কার্যক্রম প্রতিরোধ করার জন্য।</li>
                    <li>নতুন আপডেট, নোটিফিকেশন বা প্রমোশনাল অফার আপনার ইমেইলে পাঠানোর জন্য (আপনি চাইলে এটি বন্ধ করতে পারেন)।</li>
                </ul>

                <h3>৩. তথ্য শেয়ারিং এবং থার্ড-পার্টি</h3>
                <p>আমরা কখনোই আপনার ব্যক্তিগত তথ্য কোনো তৃতীয় পক্ষের কাছে বিক্রি করি না। তবে নিচের ক্ষেত্রে আমরা তথ্য শেয়ার করতে পারি:</p>
                <ul>
                    <li><strong>সার্ভিস প্রোভাইডার:</strong> পেমেন্ট গেটওয়ে (যেমন- বিকাশ, নগদ) বা ইমেইল সার্ভিসের মতো থার্ড-পার্টি সার্ভিস যারা আমাদের প্ল্যাটফর্ম পরিচালনায় সাহায্য করে। তারা শুধুমাত্র তাদের কাজ সম্পাদনের জন্য প্রয়োজনীয় তথ্য পায় এবং তা গোপনে রাখতে বাধ্য থাকে।</li>
                    <li><strong>আইনি বাধ্যবাধকতা:</strong> সরকারি বা আইনি সংস্থা যদি আইনি প্রক্রিয়ায় কোনো তথ্য তলব করে, তবে দেশের আইন মেনে আমরা তা প্রদান করতে বাধ্য থাকতে পারি।</li>
                </ul>

                <h3>৪. কুকিজ (Cookies) ব্যবহার</h3>
                <p>আমাদের ওয়েবসাইট আপনার ব্রাউজিং অভিজ্ঞতা উন্নত করতে এবং আপনাকে দ্রুত লগইন করতে সাহায্য করার জন্য কুকিজ ব্যবহার করে। আপনি চাইলে আপনার ব্রাউজার সেটিংস থেকে কুকিজ বন্ধ করতে পারেন, তবে এর ফলে ওয়েবসাইটের কিছু ফিচার সঠিকভাবে কাজ না-ও করতে পারে।</p>

                <h3>৫. আপনার তথ্যের নিরাপত্তা</h3>
                <p>আপনার ব্যক্তিগত ডেটা সুরক্ষিত রাখতে আমরা ইন্ডাস্ট্রি-স্ট্যান্ডার্ড এনক্রিপশন এবং সিকিউরিটি প্রোটোকল ব্যবহার করি। তবে ইন্টারনেটে ডেটা আদান-প্রদান ১০০% সুরক্ষিত নয়, তাই আপনি আপনার পাসওয়ার্ড বা অ্যাকাউন্টের গোপনীয়তা নিজে থেকে রক্ষা করতে সচেষ্ট থাকবেন।</p>

                <h3>৬. আপনার অধিকার</h3>
                <p>আপনার অ্যাকাউন্টের যেকোনো তথ্য সংশোধন, আপডেট বা ডিলিট করার অধিকার আপনার আছে। আপনি চাইলে আপনার প্রোফাইল সেটিংস থেকে তা পরিবর্তন করতে পারেন বা আমাদের সাপোর্টে যোগাযোগ করে অ্যাকাউন্ট পুরোপুরি মুছে ফেলার (Delete Account) অনুরোধ করতে পারেন।</p>

                <h3>৭. নীতিমালার পরিবর্তন</h3>
                <p>আমরা প্রয়োজন অনুযায়ী যেকোনো সময় এই গোপনীয়তা নীতি আপডেট করতে পারি। নীতিমালায় কোনো বড় পরিবর্তন আসলে আমরা ওয়েবসাইটের মাধ্যমে বা ইমেইলে আপনাকে তা অবহিত করবো।</p>

                <h3>৮. যোগাযোগ</h3>
                <p>আমাদের গোপনীয়তা নীতি সম্পর্কে আপনার কোনো প্রশ্ন, পরামর্শ বা অভিযোগ থাকলে আমাদের সাথে যোগাযোগ করতে পারেন:</p>
                <p>
                    <strong>ইমেইল:</strong> support@qbankbd.com<br>
                </p>
            </div>
        </div>
    </div>
</main>

<footer class="border-t border-sky-200/60 bg-white py-8 px-4 dark:border-sky-700/30 dark:bg-[#13172b]">
    <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 text-sm text-slate-500 dark:text-slate-400 sm:flex-row">
        <p>© {{ date('Y') }} {{ $siteName }}। সর্বস্বত্ব সংরক্ষিত।</p>
        <div class="flex gap-4">
            <a href="{{ route('home') }}" class="hover:text-sky-600 dark:hover:text-sky-400">হোমপেজ</a>
        </div>
    </div>
</footer>

</body>
</html>

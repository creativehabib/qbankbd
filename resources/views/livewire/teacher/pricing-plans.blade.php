<div class="space-y-6">
    <h1 class="text-2xl font-bold">প্রাইসিং</h1>
    <div class="grid gap-5 md:grid-cols-3">
        @foreach($plans as $plan)
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold">{{ $plan['name'] }}</h2>
                <p class="mt-2 text-2xl font-bold">৳{{ number_format($plan['price']) }}</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li>Question Create - {{ $plan['question_create'] }}</li>
                    <li>Page View - {{ $plan['page_view'] }}</li>
                    <li>Ad Free Content - {{ $plan['ad_free'] }}</li>
                </ul>
            </div>
        @endforeach
    </div>
</div>

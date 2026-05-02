<div class="space-y-6">
    <h1 class="text-2xl font-bold">প্রাইসিং</h1>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">{{ session('success') }}</div>
    @endif
    @error('purchase')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror

    <div class="grid gap-5 md:grid-cols-3">
        @forelse($plans as $plan)
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-lg font-semibold">{{ $plan->name }}</h2>
                <p class="mt-2 text-2xl font-bold">৳{{ number_format((float) $plan->price) }}</p>
                <ul class="mt-4 space-y-2 text-sm">
                    <li>Question Create - {{ $plan->question_create_limit }}</li>
                    <li>Page View - {{ $plan->page_view_limit ?: 'Unlimited' }}</li>
                    <li>Ad Free Content - {{ $plan->is_ad_free ? 'Unlimited' : 'No' }}</li>
                </ul>
                <a wire:navigate href="{{ route('teacher.pricing.checkout', $plan) }}" class="mt-4 w-full rounded-lg bg-indigo-600 py-2 font-semibold text-white">Buy Package</a>
            </div>
        @empty
            <div class="col-span-full rounded-xl border border-dashed border-zinc-300 p-8 text-center text-zinc-500 dark:border-zinc-700">কোনো package পাওয়া যায়নি।</div>
        @endforelse
    </div>
</div>

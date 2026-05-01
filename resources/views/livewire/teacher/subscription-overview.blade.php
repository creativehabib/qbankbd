<div class="space-y-6">
    <h1 class="text-2xl font-bold">আমার সাবস্ক্রিপশন</h1>

    @if($subscription)
        <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="grid gap-4 md:grid-cols-2">
                <div><p class="text-sm text-zinc-500">Package Name</p><p class="font-semibold">{{ $subscription->package?->name }}</p></div>
                <div><p class="text-sm text-zinc-500">Type</p><p class="font-semibold">{{ $subscription->package?->validity_days }} Days</p></div>
                <div><p class="text-sm text-zinc-500">Validity</p><p class="font-semibold">{{ $subscription->started_at?->format('d M Y') }} - {{ $subscription->expires_at?->format('d M Y') }}</p></div>
                <div><p class="text-sm text-zinc-500">Activity Limit</p><p class="font-semibold">Question Create {{ $subscription->remaining_question_limit }}</p></div>
                <div><p class="text-sm text-zinc-500">Page View</p><p class="font-semibold">{{ $subscription->package?->page_view_limit ? $subscription->package?->page_view_limit : 'Unlimited' }}</p></div>
                <div><p class="text-sm text-zinc-500">Ad Free Content</p><p class="font-semibold">{{ $subscription->package?->is_ad_free ? 'Unlimited' : 'No' }}</p></div>
            </div>
        </div>
    @else
        <div class="rounded-xl border border-dashed border-zinc-300 p-8 text-center text-zinc-500 dark:border-zinc-700">
            আপনার এখনও কোনো active subscription নেই।
        </div>
    @endif
</div>

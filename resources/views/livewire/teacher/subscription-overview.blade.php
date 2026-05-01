<div class="space-y-6">
    <h1 class="text-2xl font-bold">আমার সাবস্ক্রিপশন</h1>
    <div class="rounded-xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
        <div class="grid gap-4 md:grid-cols-2">
            <div><p class="text-sm text-zinc-500">Package Name</p><p class="font-semibold">{{ $subscription['package_name'] }}</p></div>
            <div><p class="text-sm text-zinc-500">Type</p><p class="font-semibold">{{ $subscription['type'] }}</p></div>
            <div><p class="text-sm text-zinc-500">Validity</p><p class="font-semibold">{{ $subscription['validity'] }}</p></div>
            <div><p class="text-sm text-zinc-500">Activity Limit</p><p class="font-semibold">{{ $subscription['activity_limit'] }}</p></div>
            <div><p class="text-sm text-zinc-500">Page View</p><p class="font-semibold">{{ $subscription['page_view'] }}</p></div>
            <div><p class="text-sm text-zinc-500">Ad Free Content</p><p class="font-semibold">{{ $subscription['ad_free'] }}</p></div>
        </div>
    </div>
</div>

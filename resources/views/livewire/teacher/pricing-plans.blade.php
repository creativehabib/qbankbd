<div>
    <div class="space-y-12 pb-12">
        @if (session()->has('error'))
            <div class="max-w-2xl mx-auto mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if (session()->has('success'))
            <div class="max-w-2xl mx-auto mt-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mt-6">
            <h1 class="text-3xl font-black text-zinc-900 dark:text-white">Upgrade Your Educator Profile</h1>
            <p class="mt-3 text-zinc-500 dark:text-zinc-400">Choose a plan that fits your teaching needs and unlock more tools to engage your students.</p>
        </div>

        @if($plans->isNotEmpty())
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center justify-center gap-2 text-zinc-800 dark:text-zinc-200">
                    <flux:icon.briefcase class="size-6 text-indigo-500" /> Educator Subscriptions
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    @foreach($plans as $plan)
                        @php
                            $isActive = auth()->user()->hasActivePackage($plan->id);
                            $borderClass = $isActive ? 'border-2 border-emerald-500 shadow-xl' : ($loop->iteration == 2 ? 'border-2 border-indigo-500 shadow-xl' : '');
                        @endphp
                        <flux:card class="relative flex flex-col {{ $borderClass }}">
                            @if($isActive)
                                <div class="absolute -top-3 left-0 right-0 flex justify-center">
                                    <span class="bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1"><flux:icon.check-badge class="size-4" /> Current Plan</span>
                                </div>
                            @elseif($loop->iteration == 2)
                                <div class="absolute -top-3 left-0 right-0 flex justify-center">
                                    <span class="bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Most Popular</span>
                                </div>
                            @endif
                            <div class="text-center border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-4 mt-2">
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $plan->name }}</h3>
                                <div class="mt-2 text-4xl font-black text-indigo-600 dark:text-indigo-400">৳{{ number_format((float) $plan->price) }}</div>
                                <div class="text-sm text-zinc-500 mt-1">per {{ $plan->validity_days }} days</div>
                            </div>
                            <div class="flex-grow space-y-3 mb-6 text-sm text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-start gap-2">
                                    <flux:icon.document-plus class="size-5 text-indigo-500 shrink-0"/> 
                                    <span><strong>{{ $plan->question_create_limit ?: 'Unlimited' }}</strong> Question Creations</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <flux:icon.eye class="size-5 text-indigo-500 shrink-0"/> 
                                    <span><strong>{{ $plan->page_view_limit ?: 'Unlimited' }}</strong> Page Views</span>
                                </div>
                                <div class="flex items-start gap-2">
                                    <flux:icon.bolt class="size-5 text-indigo-500 shrink-0"/> 
                                    <span>{{ $plan->is_ad_free ? 'Ad-Free Experience' : 'Contains Ads' }}</span>
                                </div>
                                @if($plan->description)
                                    <div class="flex items-start gap-2">
                                        <flux:icon.check-circle class="size-5 text-emerald-500 shrink-0"/> 
                                        <span>{{ $plan->description }}</span>
                                    </div>
                                @endif
                            </div>
                            @if($isActive)
                                <flux:button variant="filled" class="w-full bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 cursor-default">
                                    Current Plan
                                </flux:button>
                            @else
                                <flux:button href="{{ route('teacher.pricing.checkout', $plan->id) }}" variant="{{ $loop->iteration == 2 ? 'primary' : 'outline' }}" class="w-full">
                                    Subscribe Now
                                </flux:button>
                            @endif
                        </flux:card>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12 text-zinc-500">
                No active educator plans found.
            </div>
        @endif
    </div>
</div>

<div>
    <div class="space-y-12">
        @if (session()->has('error'))
            <div class="max-w-2xl mx-auto mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        
        @if (session()->has('warning'))
            <div class="max-w-2xl mx-auto mt-6 bg-amber-100 border border-amber-400 text-amber-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto mt-6">
            <h1 class="text-3xl font-black text-zinc-900 dark:text-white">Upgrade Your Learning Journey</h1>
            <p class="mt-3 text-zinc-500 dark:text-zinc-400">Choose a Pro Subscription for unlimited access or buy a specific Special Course.</p>
        </div>

        @if($subscriptions->isNotEmpty())
            <div>
                <h2 class="text-2xl font-bold mb-6 flex items-center justify-center gap-2 text-zinc-800 dark:text-zinc-200">
                    <flux:icon.sparkles class="size-6 text-amber-500" /> Pro Subscriptions
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                    @foreach($subscriptions as $plan)
                        <flux:card class="relative flex flex-col {{ $loop->iteration == 2 ? 'border-2 border-indigo-500 shadow-xl' : '' }}">
                            @if($loop->iteration == 2)
                                <div class="absolute -top-3 left-0 right-0 flex justify-center">
                                    <span class="bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">Most Popular</span>
                                </div>
                            @endif
                            <div class="text-center border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-4 mt-2">
                                <h3 class="text-lg font-bold text-zinc-900 dark:text-white">{{ $plan->name }}</h3>
                                <div class="mt-2 text-4xl font-black text-indigo-600 dark:text-indigo-400">৳{{ number_format($plan->price) }}</div>
                                <div class="text-sm text-zinc-500 mt-1">per {{ $plan->validity_days }} days</div>
                            </div>
                            <div class="flex-grow space-y-3 mb-6 text-sm text-zinc-600 dark:text-zinc-400">
                                <div class="flex items-start gap-2"><flux:icon.check-circle class="size-5 text-emerald-500 shrink-0"/> Access all Premium Model Tests</div>
                                <div class="flex items-start gap-2"><flux:icon.check-circle class="size-5 text-emerald-500 shrink-0"/> Detailed AI Explanations</div>
                                <div class="flex items-start gap-2"><flux:icon.check-circle class="size-5 text-emerald-500 shrink-0"/> Ad-Free Experience</div>
                                @if($plan->description)
                                    <div class="flex items-start gap-2"><flux:icon.check-circle class="size-5 text-emerald-500 shrink-0"/> {{ $plan->description }}</div>
                                @endif
                            </div>
                            <flux:button href="{{ route('student.checkout', $plan->id) }}" variant="{{ $loop->iteration == 2 ? 'primary' : 'outline' }}" class="w-full">
                                Subscribe Now
                            </flux:button>
                        </flux:card>
                    @endforeach
                </div>
            </div>
        @endif

        @if($courses->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-6 flex items-center justify-center gap-2 text-zinc-800 dark:text-zinc-200">
                    <flux:icon.academic-cap class="size-6 text-emerald-500" /> Special Courses
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                    @foreach($courses as $course)
                        <flux:card class="flex flex-col sm:flex-row gap-6 p-0 overflow-hidden">
                            @if($course->thumbnail_image)
                                <div class="w-full sm:w-1/3 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center min-h-[150px]">
                                    <img src="{{ $course->thumbnail_image }}" alt="Course Cover" class="object-cover w-full h-full">
                                </div>
                            @else
                                <div class="w-full sm:w-1/3 bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center min-h-[150px]">
                                    <flux:icon.academic-cap class="size-16 text-white/50" />
                                </div>
                            @endif
                            <div class="p-6 w-full sm:w-2/3 flex flex-col justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $course->name }}</h3>
                                    <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">{{ $course->description ?? 'Special targeted preparation course.' }}</p>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="text-2xl font-black text-emerald-600 dark:text-emerald-400">৳{{ number_format($course->price) }}</div>
                                    <flux:button href="{{ route('student.checkout', $course->id) }}" variant="primary">Enroll Now</flux:button>
                                </div>
                            </div>
                        </flux:card>
                    @endforeach
                </div>
            </div>
        @endif
        
    </div>
</div>

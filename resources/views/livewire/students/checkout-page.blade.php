<div class="max-w-2xl mx-auto mt-10">
    <flux:card>
        <h2 class="text-2xl font-bold mb-6 text-zinc-800 dark:text-zinc-100 border-b pb-4 dark:border-zinc-800">Checkout</h2>
        
        <div class="flex items-center gap-4 mb-8 bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-xl border border-zinc-100 dark:border-zinc-800">
            <div class="size-16 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500">
                <flux:icon name="{{ $package->type === 'course' ? 'academic-cap' : 'sparkles' }}" class="size-8" />
            </div>
            <div>
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">{{ $package->name }}</h3>
                <p class="text-sm text-zinc-500">{{ ucfirst($package->type) }} &bull; Valid for {{ $package->validity_days }} days</p>
            </div>
            <div class="ml-auto text-2xl font-black text-emerald-600 dark:text-emerald-400">
                ৳{{ number_format($package->price) }}
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-bold text-zinc-700 dark:text-zinc-300">Select Payment Method</h3>
            
            @php
                $paymentSettings = \App\Support\SettingsStore::group('payment');
                $bkashEnabled = $paymentSettings['bkash_active'] ?? false;
                $sslEnabled = $paymentSettings['sslcommerz_active'] ?? false;
            @endphp

            @if(!$bkashEnabled && !$sslEnabled)
                <div class="p-4 bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 rounded-xl text-center font-medium border border-amber-100 dark:border-amber-800">
                    <flux:icon.exclamation-triangle class="size-6 mx-auto mb-2" />
                    পেমেন্ট সিস্টেম বর্তমানে বন্ধ আছে। দয়া করে এডমিনের সাথে যোগাযোগ করুন।
                </div>
            @else
                <div class="grid grid-cols-2 gap-4">
                    @if($bkashEnabled)
                    <form action="{{ route('payment.bkash.pay', $package->id) }}" method="POST" class="w-full h-full block">
                        @csrf
                        <button type="submit" class="w-full h-full border-2 border-zinc-200 dark:border-zinc-700 hover:border-pink-500 dark:hover:border-pink-500 hover:bg-pink-50 dark:hover:bg-pink-500/10 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition text-zinc-700 dark:text-zinc-300">
                            <div class="font-black text-3xl tracking-tighter" style="color:#e2136e">bKash</div>
                            <span class="font-bold">Pay with bKash</span>
                        </button>
                    </form>
                    @endif
                    
                    @if($sslEnabled)
                    <form action="{{ route('payment.ssl.pay', $package->id) }}" method="POST" class="w-full h-full block">
                        @csrf
                        <button type="submit" class="w-full h-full border-2 border-zinc-200 dark:border-zinc-700 hover:border-blue-500 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-500/10 rounded-xl p-4 flex flex-col items-center justify-center gap-2 transition text-zinc-700 dark:text-zinc-300">
                            <div class="font-black text-2xl tracking-tighter" style="color:#0f5898">SSLCommerz</div>
                            <span class="font-bold">Cards / Mobile Banking</span>
                        </button>
                    </form>
                    @endif
                </div>
                
                <div class="mt-8 text-center text-xs text-zinc-400">
                    * You will be redirected to the secure payment gateway to complete your transaction.
                </div>
            @endif
        </div>
    </flux:card>
</div>

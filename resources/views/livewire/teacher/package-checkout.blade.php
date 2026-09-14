<div class="mx-auto max-w-5xl space-y-6">
    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <h1 class="text-2xl font-bold">Checkout</h1>
        <p class="mt-1 text-sm text-zinc-500">প্যাকেজ: <span class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $package->name }}</span></p>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="text-lg font-semibold">Select Payment Method</h2>
            @error('paymentMethod')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror

            <div class="mt-5 space-y-3">
                <button type="button" wire:click="$set('paymentMethod', 'wallet')" class="w-full rounded-xl border p-4 text-left {{ $paymentMethod === 'wallet' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-300 dark:border-zinc-700' }}">
                    <p class="font-semibold">A/C Balance</p>
                    <p class="text-sm text-zinc-600 dark:text-zinc-300">Credit = ৳{{ (int) $wallet->credit_balance }} & Reward = ৳{{ (int) $wallet->reward_balance }} = ৳{{ (int) $totalBalance }}</p>
                </button>

                @php
                    $paymentSettings = \App\Support\SettingsStore::group('payment');
                    $bkashEnabled = $paymentSettings['bkash_active'] ?? false;
                    $sslEnabled = $paymentSettings['sslcommerz_active'] ?? false;
                    $nagadEnabled = $paymentSettings['nagad_active'] ?? false;
                @endphp

                @if($bkashEnabled)
                    <button type="button" wire:click="$set('paymentMethod', 'bkash')" class="flex w-full items-center gap-3 rounded-xl border p-4 text-left {{ $paymentMethod === 'bkash' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-300 dark:border-zinc-700 hover:border-pink-500' }}">
                        <img src="{{ asset('images/bkash_logo.svg') }}" alt="bKash" class="h-8 object-contain">
                        <span class="font-semibold">bKash</span>
                    </button>
                @endif
                
                @if($nagadEnabled)
                    <button type="button" wire:click="$set('paymentMethod', 'nagad')" class="flex w-full items-center gap-3 rounded-xl border p-4 text-left {{ $paymentMethod === 'nagad' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-300 dark:border-zinc-700 hover:border-orange-500' }}">
                        <img src="{{ asset('images/nagad_logo.svg') }}" alt="Nagad" class="h-6 object-contain">
                        <span class="font-semibold">Nagad</span>
                    </button>
                @endif

                @if($sslEnabled)
                    <button type="button" wire:click="$set('paymentMethod', 'sslcommerz')" class="flex w-full items-center gap-3 rounded-xl border p-4 text-left {{ $paymentMethod === 'sslcommerz' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-300 dark:border-zinc-700 hover:border-blue-500' }}">
                        <img src="{{ asset('images/sslcommerz_logo.png') }}" alt="SSLCommerz" class="h-6 object-contain">
                        <span class="font-semibold">Cards / Mobile Banking</span>
                    </button>
                @endif
                
                <button type="button" wire:click="$set('paymentMethod', 'manual')" class="flex w-full items-center justify-between rounded-xl border p-4 text-left {{ $paymentMethod === 'manual' ? 'border-indigo-600 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-300 dark:border-zinc-700' }}">
                    <span class="font-semibold">Manual Payment</span>
                    <span class="rounded-full bg-zinc-100 px-3 py-1 text-xs text-zinc-500 dark:bg-zinc-800">Coming Soon</span>
                </button>
            </div>
        </div>

        <div class="rounded-2xl border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="text-lg font-semibold">Order Summary</h3>
            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><span>Package</span><span>{{ $package->name }}</span></div>
                <div class="flex justify-between"><span>Validity</span><span>{{ $package->validity_days }} days</span></div>
                <div class="flex justify-between"><span>Question Limit</span><span>{{ $package->question_create_limit }}</span></div>
                <div class="border-t pt-2 mt-2 flex justify-between text-base font-bold"><span>Total</span><span>৳{{ number_format((float) $package->price) }}</span></div>
            </div>

            @if($paymentMethod === 'wallet' || $paymentMethod === 'manual')
                <button wire:click="confirmPurchase" class="mt-5 w-full rounded-xl bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700">Pay Now</button>
            @elseif($paymentMethod === 'bkash')
                <form action="{{ route('payment.bkash.pay', $package->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="mt-5 w-full rounded-xl bg-pink-600 px-4 py-3 font-semibold text-white hover:bg-pink-700">Pay with bKash</button>
                </form>
            @elseif($paymentMethod === 'sslcommerz')
                <form action="{{ route('payment.ssl.pay', $package->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="mt-5 w-full rounded-xl bg-blue-600 px-4 py-3 font-semibold text-white hover:bg-blue-700">Pay with SSLCommerz</button>
                </form>
            @elseif($paymentMethod === 'nagad')
                <form action="{{ route('payment.nagad.pay', $package->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="mt-5 w-full rounded-xl bg-orange-600 px-4 py-3 font-semibold text-white hover:bg-orange-700">Pay with Nagad</button>
                </form>
            @endif
            <a wire:navigate href="{{ route('teacher.pricing') }}" class="mt-3 block text-center text-sm text-zinc-500 hover:text-zinc-700">Back to pricing</a>
        </div>
    </div>
</div>

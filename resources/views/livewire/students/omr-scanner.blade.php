<div class="mx-auto max-w-2xl space-y-6">
    <div class="text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-500/20">
            <flux:icon.document-magnifying-glass class="size-8 text-emerald-600 dark:text-emerald-400" />
        </div>
        <h2 class="mt-4 text-2xl font-bold text-zinc-900 dark:text-zinc-100">OMR শিট স্ক্যানার</h2>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">আপনার পূরণ করা OMR শিটের একটি পরিষ্কার ছবি তুলে আপলোড করুন।</p>
    </div>

    <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">

        <form wire:submit.prevent="processOmr">
            <div
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                class="relative mt-2 flex justify-center rounded-xl border-2 border-dashed border-zinc-300 px-6 py-10 transition-colors hover:border-emerald-500 dark:border-zinc-700 dark:hover:border-emerald-500"
            >
                <div class="text-center">
                    @if ($omrImage && in_array(strtolower($omrImage->extension()), ['png', 'jpg', 'jpeg']))
                        <div class="relative mx-auto h-64 w-48 overflow-hidden rounded-lg border border-zinc-200 shadow-sm">
                            <img src="{{ $omrImage->temporaryUrl() }}" class="h-full w-full object-cover" alt="OMR Preview">

                            <div wire:loading wire:target="processOmr" class="absolute inset-0 bg-emerald-500/20 backdrop-blur-[2px]">
                                <div class="absolute left-0 right-0 top-0 h-1 w-full animate-[scan_2s_ease-in-out_infinite] bg-emerald-500 shadow-[0_0_8px_2px_rgba(16,185,129,0.5)]"></div>
                            </div>
                        </div>
                        <button type="button" wire:click="$set('omrImage', null)" onchange="document.getElementById('omr-upload').value = ''" class="mt-4 text-sm font-semibold text-red-500 hover:text-red-600 transition">
                            ছবি পরিবর্তন করুন
                        </button>

                    @elseif($omrImage)
                        <div class="relative mx-auto flex h-64 w-48 items-center justify-center overflow-hidden rounded-lg border border-zinc-200 bg-zinc-50 shadow-sm dark:bg-zinc-800 dark:border-zinc-700">
                            <div class="text-center">
                                <flux:icon.document-check class="mx-auto size-10 text-emerald-500" />
                                <p class="mt-2 text-sm font-medium text-zinc-600 dark:text-zinc-400">ফাইল সিলেক্ট হয়েছে</p>
                            </div>
                            <div wire:loading wire:target="processOmr" class="absolute inset-0 bg-emerald-500/20 backdrop-blur-[2px]"></div>
                        </div>
                        <button type="button" wire:click="$set('omrImage', null)" onchange="document.getElementById('omr-upload').value = ''" class="mt-4 text-sm font-semibold text-red-500 hover:text-red-600 transition">
                            ছবি পরিবর্তন করুন
                        </button>

                    @else
                        <flux:icon.photo class="mx-auto size-12 text-zinc-300 dark:text-zinc-600" />
                        <div class="mt-4 flex justify-center text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                            <label for="omr-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-emerald-600 focus-within:outline-none hover:text-emerald-500 dark:text-emerald-400">
                                <span>ফাইল সিলেক্ট করুন</span>
                                <input id="omr-upload" wire:model="omrImage" type="file" accept=".jpg, .jpeg, .png" class="sr-only">
                            </label>
                        </div>
                        <p class="text-xs leading-5 text-zinc-500 mt-1">PNG, JPG (সর্বোচ্চ ৫ মেগাবাইট)</p>
                    @endif
                </div>

                <div x-show="isUploading" class="absolute bottom-4 left-1/2 w-64 -translate-x-1/2">
                    <div class="h-2 w-full rounded-full bg-zinc-200 dark:bg-zinc-700">
                        <div class="h-2 rounded-full bg-emerald-500 transition-all duration-300" :style="`width: ${progress}%`"></div>
                    </div>
                </div>
            </div>

            @error('omrImage') <span class="mt-2 block text-center text-sm font-semibold text-red-500">{{ $message }}</span> @enderror

            <div class="mt-6">
                <button
                    type="submit"
                    @if(!$omrImage) disabled @endif
                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <span wire:loading.remove wire:target="processOmr" class="flex items-center gap-2">
                        <flux:icon.cpu-chip class="size-5" /> স্ক্যান করে রেজাল্ট দেখুন
                    </span>
                    <span wire:loading wire:target="processOmr" class="flex items-center gap-2">
                        <flux:icon.arrow-path class="size-5 animate-spin" /> OMR প্রসেস করছে...
                    </span>
                </button>
            </div>
        </form>

        @if($scanResult)
            <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-900/30 dark:bg-emerald-900/10">
                <h3 class="font-bold text-emerald-800 dark:text-emerald-400 border-b border-emerald-200 dark:border-emerald-800 pb-2 mb-3">স্ক্যান রেজাল্ট:</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($scanResult as $question => $answerLetter)
                        @php
                            // পাইথন থেকে আসা A, B, C, D কে ক, খ, গ, ঘ তে কনভার্ট করা
                            $banglaOptions = [
                                'A' => 'ক',
                                'B' => 'খ',
                                'C' => 'গ',
                                'D' => 'ঘ',
                                'N/A' => 'N/A'
                            ];
                        @endphp
                        <div class="bg-white dark:bg-zinc-800 p-2 text-center rounded-lg border border-emerald-100 dark:border-zinc-700 shadow-sm">
                            <span class="text-xs text-zinc-500 font-bold block">প্রশ্ন {{ $question }}</span>
                            <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">
                                {{ $banglaOptions[$answerLetter] ?? $answerLetter }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<style>
    @keyframes scan {
        0% { top: 0%; opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { top: 100%; opacity: 0; }
    }
</style>

<main class="flex flex-col xl:flex-row gap-6 my-6 max-w-7xl mx-auto px-4">

    <style>
        @keyframes scanner {
            0% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scanner {
            animation: scanner 2s linear infinite;
        }
    </style>

    <div class="flex-[3] space-y-6">

        <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden shadow-sm">
            <div class="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-zinc-500 size-5" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16v-6H5l7-7l7 7h-4v6zm-4 4v-2h14v2z"></path></svg>
                <h2 class="font-semibold tracking-tight">Upload OMR Sheet</h2>
            </div>

            <div class="p-5 xl:p-8 relative">

                @if(session()->has('message'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg font-bold">{{ session('message') }}</div>
                @endif
                @error('scan')
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">{{ $message }}</div>
                @enderror

                @if(!$photo && !$scannedImageUrl)
                    <div x-data="{ isDropping: false }"
                         x-on:dragover.prevent="isDropping = true"
                         x-on:dragleave.prevent="isDropping = false"
                         x-on:drop.prevent="isDropping = false; $wire.upload('photo', $event.dataTransfer.files[0])"
                         x-bind:class="isDropping ? 'border-green-500 bg-green-50' : 'border-zinc-300 hover:border-green-500 hover:bg-zinc-50'"
                         class="relative border-2 border-dashed rounded-xl p-8 text-center transition-all flex flex-col items-center justify-center min-h-[300px] cursor-pointer">

                        <input type="file" wire:model="photo" accept="image/*,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                        <div class="bg-zinc-100 p-4 rounded-full mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-10 text-zinc-500" viewBox="0 0 24 24"><path fill="currentColor" d="M11 20H6.5q-2.28 0-3.89-1.57Q1 16.85 1 14.58q0-1.95 1.17-3.48q1.18-1.53 3.08-1.95q.63-2.3 2.5-3.72Q9.63 4 12 4q2.93 0 4.96 2.04Q19 8.07 19 11q1.73.2 2.86 1.5q1.14 1.28 1.14 3q0 1.88-1.31 3.19T18.5 20H13v-7.15l1.6 1.55L16 13l-4-4l-4 4l1.4 1.4l1.6-1.55Z"></path></svg>
                        </div>
                        <h3 class="font-bold mb-2">Drag & Drop your OMR sheet here</h3>
                        <p class="text-zinc-500 mb-4 text-sm">or click to browse from your computer</p>
                        <p class="text-xs font-semibold px-3 py-1 bg-zinc-100 text-zinc-600 rounded-md">Supported formats: JPG, PNG, PDF (Max 10MB)</p>
                    </div>
                @else
                    <div class="relative bg-zinc-50 rounded-xl p-4 border border-zinc-200 flex justify-center min-h-[300px] overflow-hidden">
                        <button wire:click="removePhoto" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 z-30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"><path fill="currentColor" d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12z"/></svg>
                        </button>

                        <div wire:loading wire:target="scanOmr" class="absolute inset-0 z-20 flex items-center justify-center bg-black/40 backdrop-blur-sm">

                            <div class="absolute w-full h-[3px] bg-green-500 shadow-[0_0_15px_4px_rgba(34,197,94,0.7)] animate-scanner left-0"></div>

                            <div class="bg-white px-6 py-3 rounded-full shadow-2xl font-bold text-green-600 flex items-center gap-3 animate-pulse border border-green-200">
                                <svg class="size-6 animate-spin text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                স্ক্যান করা হচ্ছে...
                            </div>
                        </div>

                        @if($scannedImageUrl)
                            <img src="{{ $scannedImageUrl }}" class="max-h-[500px] object-contain shadow-md border" alt="Scanned OMR">
                        @else
                            @if(in_array(strtolower($photo->extension()), ['jpg', 'jpeg', 'png']))
                                <img src="{{ $photo->temporaryUrl() }}" class="max-h-[500px] object-contain shadow-md border" alt="Preview">
                            @else
                                <div class="flex flex-col items-center justify-center w-full h-[300px] bg-zinc-100 rounded-xl border border-zinc-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-16 text-zinc-400 mb-2" viewBox="0 0 24 24"><path fill="currentColor" d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/></svg>
                                    <span class="font-bold text-zinc-600">PDF File Selected</span>
                                    <span class="text-sm text-zinc-500 mt-1">{{ $photo->getClientOriginalName() }}</span>
                                </div>
                            @endif
                        @endif
                    </div>
                @endif

                <div class="mt-6 text-center flex justify-center">
                    <button wire:click="scanOmr"
                            wire:loading.attr="disabled"
                            @if(!$photo && !$scannedImageUrl) disabled @endif
                            class="inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-green-600 hover:bg-green-700 disabled:bg-zinc-300 disabled:cursor-not-allowed text-white font-bold rounded-xl shadow-sm transition-all min-w-[280px]">
                        <span wire:loading.remove wire:target="scanOmr">Scan and Match OMR</span>
                        <span wire:loading wire:target="scanOmr">Scanning... Please wait</span>
                    </button>
                </div>
            </div>
        </div>

        @if(!empty($stats))
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-xl border border-zinc-200 text-center shadow-sm">
                    <h3 class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</h3>
                    <p class="text-xs font-bold text-zinc-500 mt-1 uppercase">Total</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-zinc-200 text-center shadow-sm">
                    <h3 class="text-3xl font-bold text-green-600">{{ $stats['correct'] }}</h3>
                    <p class="text-xs font-bold text-zinc-500 mt-1 uppercase">Correct</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-zinc-200 text-center shadow-sm">
                    <h3 class="text-3xl font-bold text-red-600">{{ $stats['wrong'] }}</h3>
                    <p class="text-xs font-bold text-zinc-500 mt-1 uppercase">Wrong</p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-zinc-200 text-center shadow-sm">
                    <h3 class="text-3xl font-bold text-yellow-500">{{ $stats['unanswered'] }}</h3>
                    <p class="text-xs font-bold text-zinc-500 mt-1 uppercase">Unanswered</p>
                </div>
                <div class="col-span-2 md:col-span-4 bg-green-50 p-4 rounded-xl border border-green-200 text-center shadow-sm mt-2">
                    <h3 class="text-4xl font-bold text-green-700">{{ $stats['score'] }}</h3>
                    <p class="text-sm font-bold text-green-600 mt-1">প্রাপ্ত নাম্বার (নেগেটিভ মার্ক বাদে)</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl border border-zinc-200 overflow-hidden shadow-sm">
            <div class="bg-zinc-50 border-b border-zinc-200 px-5 py-4 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <svg class="text-zinc-500 size-5" viewBox="0 0 24 24"><path fill="currentColor" d="M3 5h6v6H3zm2 2v2h2V7zm6 0h10v2H11zm0 8h10v2H11zm-6 5l-3.5-3.5l1.41-1.41L5 17.17l4.59-4.58L11 14z"></path></svg>
                    <h3 class="font-bold tracking-tight">সঠিক উত্তরপত্র তৈরি করুন (Answer Key)</h3>
                </div>
                <div class="flex items-center gap-3">
                    <select wire:model="negativeMark" class="bg-white border border-zinc-200 rounded-lg px-3 py-1.5 text-xs font-medium focus:border-green-500 outline-none">
                        <option value="0">No Negative Mark</option>
                        <option value="0.25">-0.25</option>
                        <option value="0.50">-0.50</option>
                        <option value="1">-1.00</option>
                    </select>
                </div>
            </div>

            <div class="p-4 md:p-6 columns-1 sm:columns-2 md:columns-3 xl:columns-4 gap-6">
                @for($i = 1; $i <= $totalQuestions; $i++)
                    <div class="flex items-center justify-end break-inside-avoid mb-3">
                        <div class="w-8 font-bold text-right mr-3 text-zinc-500">{{ $i }}</div>
                        <div class="flex gap-2">
                            @foreach(['A' => 'ক', 'B' => 'খ', 'C' => 'গ', 'D' => 'ঘ'] as $key => $label)
                                @php
                                    $isSelected = isset($correctAnswers[$i]) && $correctAnswers[$i] === $key;
                                @endphp
                                <button wire:click="toggleAnswer({{ $i }}, '{{ $key }}')"
                                        class="size-6 md:size-7 rounded-full border text-sm font-bold transition-all flex items-center justify-center
                                    {{ $isSelected ? 'bg-green-500 text-white border-green-500 scale-110 shadow-md' : 'bg-white text-zinc-600 border-zinc-300 hover:border-green-400 hover:text-green-600' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>

            <div class="flex items-center justify-between p-6 border-t border-zinc-200 bg-zinc-50">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-zinc-600">মোট প্রশ্ন:</label>
                    <input type="number" wire:model.live="totalQuestions" class="w-24 px-2 py-1 bg-white border border-zinc-200 rounded-lg text-center font-bold outline-none focus:border-green-500" min="10" max="200">
                </div>
                <button wire:click="saveAnswers" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-8 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path d="M15 9H5V5h10m-3 14a3 3 0 0 1-3-3a3 3 0 0 1 3-3a3 3 0 0 1-3 3m5-16H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7z"></path></svg>
                    Save Answer Key
                </button>
            </div>
        </div>
    </div>

    <div class="flex-1">
        <div class="bg-white rounded-xl border border-zinc-200 shadow-sm overflow-hidden xl:sticky xl:top-24">
            <div class="px-5 py-4 border-b border-zinc-200 bg-zinc-50 flex items-center gap-2">
                <svg class="text-zinc-500 size-5" viewBox="0 0 24 24"><path fill="currentColor" d="M13.5 8H12v5l4.28 2.54l.72-1.21l-3.5-2.08zM13 3a9 9 0 0 0-9 9H1l3.96 4.03L9 12H6a7 7 0 0 1 7-7a7 7 0 0 1 7 7a7 7 0 0 1-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.9 8.9 0 0 0 13 21a9 9 0 0 0 9-9a9 9 0 0 0-9-9"></path></svg>
                <h2 class="font-semibold tracking-tight">Recent Scans</h2>
            </div>
            <div class="p-10 text-center text-zinc-400">
                <div class="bg-zinc-100 size-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="size-10" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2M5 19v-2h3.13a4.13 4.13 0 0 0 1.27 2m9.6 0h-4.4a4.13 4.13 0 0 0 1.27-2H19m0-2h-5v1a2 2 0 0 1-4 0v-1H5V5h14Z"></path></svg>
                </div>
                <p class="font-semibold text-zinc-600">Upcoming Feature!</p>
                <p class="text-sm mt-1">Scan history will appear here</p>
            </div>
        </div>
    </div>
</main>

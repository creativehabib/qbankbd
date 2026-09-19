<div> <!-- 🌟 Master Root Element for Livewire 🌟 -->
    <div class="max-w-[100%] w-full mx-auto">
        {{-- Flash Messages --}}
        @if(session()->has('success'))
            <div class="mb-4 flex items-center gap-3 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 px-4 py-3 shadow-sm">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800">

            {{-- Header --}}
            <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-800 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-xl bg-indigo-100 dark:bg-indigo-900/50 shadow-sm border border-indigo-200 dark:border-indigo-800">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold text-gray-950 dark:text-white tracking-tight">প্রশ্ন ছবি/PDF/টেক্সট থেকে Bulk Upload</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-bold text-indigo-600 dark:text-indigo-400">Step 1:</span> ডানপাশ থেকে ক্যাটাগরি সেট করুন। এরপর বামে টেক্সট/ফাইল দিয়ে <strong>Process Questions</strong> ক্লিক করুন।
                            <span class="font-bold text-indigo-600 dark:text-indigo-400 ml-2">Step 2:</span> সঠিক উত্তর চিহ্নিত করে <strong>Submit to Database</strong> দিন।
                        </p>
                    </div>
                </div>
                
                {{-- New Question Button --}}
                <div class="shrink-0 self-start sm:self-auto">
                    <a href="{{ route('questions.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-sm hover:shadow transition-all duration-200">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg">
                            <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 112v288m144-144H112"></path>
                        </svg>
                        New Question
                    </a>
                </div>
            </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8 p-6 lg:p-8">

                {{-- ── Left Column: Main Processing Area ── --}}
                <div class="flex-1 space-y-8 w-full order-2 lg:order-1">

                    {{-- 🤖 AI Bulk Question Generator --}}
                    <div wire:key="ai-generator-card" class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 rounded-2xl border border-indigo-100 dark:border-indigo-900 p-6 shadow-sm transition hover:shadow-md">
                        <h3 class="text-base font-bold text-indigo-800 dark:text-indigo-400 flex items-center gap-2 mb-5 uppercase tracking-wider">
                            <div class="p-1.5 bg-indigo-200 dark:bg-indigo-800/50 rounded-lg text-indigo-700 dark:text-indigo-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            AI Bulk Question Generator
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-7">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">টপিক (কী নিয়ে প্রশ্ন বানাতে চান?)</label>
                                <input type="text" wire:model="aiPrompt" placeholder="যেমন: বাংলাদেশের মুক্তিযুদ্ধ, আইসিটি ১ম অধ্যায়..." class="block w-full rounded-xl border border-indigo-200 dark:border-indigo-800 bg-white dark:bg-gray-950 px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">প্রশ্নের সংখ্যা</label>
                                <input type="number" wire:model="aiQuestionCount" min="1" max="50" class="block w-full rounded-xl border border-indigo-200 dark:border-indigo-800 bg-white dark:bg-gray-950 px-4 py-3 text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 transition text-center font-bold">
                            </div>

                            <div class="md:col-span-3">
                                <button type="button" wire:click="generateBulkAiQuestions" wire:loading.attr="disabled" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-bold rounded-xl shadow-md transition-all h-[46px]">
                                    <span wire:loading.remove wire:target="generateBulkAiQuestions">Generate AI MCQ</span>
                                    <span wire:loading.flex wire:target="generateBulkAiQuestions" class="items-center justify-center gap-2">
                                        <svg class="animate-spin w-4 h-4 text-white shrink-0" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                                        <span>Thinking...</span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col mt-2">
                            @error('aiPrompt') <p class="text-xs text-red-600 font-bold bg-red-50 dark:bg-red-950/50 p-2 rounded-lg mt-1">{{ $message }}</p> @enderror
                            @error('aiQuestionCount') <p class="text-xs text-red-600 font-bold bg-red-50 dark:bg-red-950/50 p-2 rounded-lg mt-1">{{ $message }}</p> @enderror
                        </div>

                        <p class="text-sm text-indigo-700 dark:text-indigo-400 mt-4 font-medium bg-white dark:bg-indigo-950/50 p-3 rounded-lg border border-indigo-100 dark:border-indigo-800/50 flex items-center gap-2">
                            <svg class="size-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            AI একসাথে একাধিক প্রশ্ন তৈরি করে সরাসরি নিচের লিস্টে যোগ করে দেবে। (সঠিক উত্তরগুলোও AI অটোমেটিক মার্ক করে দেবে!)
                        </p>
                    </div>

                    {{-- Raw Text Textarea --}}
                    <div wire:key="ocr-raw-card" class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-900 shadow-sm transition hover:shadow-md">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-base font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                <svg class="size-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                OCR / Raw প্রশ্ন টেক্সট (Math Supported)
                            </label>
                            <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/50 px-3 py-1 rounded-full border border-indigo-200 dark:border-indigo-800">Process করার পর এখানেই formatted প্রশ্ন দেখাবে</span>
                        </div>

                        <div wire:ignore wire:key="raw-editor-box" class="ck-editor-container">
                            <textarea id="raw_text_editor" rows="12" autocomplete="off"
                                      placeholder="১. শব্দটির অর্থ কী?&#10;(ক) আলো&#10;(খ) জল&#10;(গ) বায়ু&#10;(ঘ) মাটি&#10;&#10;২. ...">{!! $rawText !!}</textarea>
                        </div>
                        @error('rawText')
                        <p class="text-sm text-red-600 font-bold bg-red-50 dark:bg-red-950/50 p-2 rounded-lg mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div wire:key="action-buttons-card" class="flex flex-wrap items-center gap-3 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-4 rounded-2xl border border-indigo-100 dark:border-indigo-900 shadow-sm">

                        <button type="button" wire:click="processQuestions"
                                wire:loading.attr="disabled" wire:target="processQuestions,sourceFile"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-base font-bold shadow hover:shadow-lg transition-all disabled:opacity-60 disabled:cursor-not-allowed">
                            <span wire:loading.remove wire:target="processQuestions">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </span>
                            <span wire:loading wire:target="processQuestions">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                </svg>
                            </span>
                            <span wire:loading.remove wire:target="processQuestions">Process Questions</span>
                            <span wire:loading wire:target="processQuestions">
                                @if($sourceFile && trim($rawText) === '') OCR চলছে... @else Processing... @endif
                            </span>
                        </button>

                        <button type="button" wire:click="submitProcessedQuestions"
                                wire:loading.attr="disabled" wire:target="submitProcessedQuestions"
                            @class([
                                'inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white text-base font-bold shadow transition-all',
                                'bg-indigo-600 hover:bg-indigo-700 hover:shadow-lg active:bg-indigo-800' => ! empty($processedQuestions),
                                'bg-gray-400 dark:bg-gray-700 cursor-not-allowed opacity-60' => empty($processedQuestions),
                            ])
                            @disabled(empty($processedQuestions))>
                            <span wire:loading.remove wire:target="submitProcessedQuestions">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span wire:loading wire:target="submitProcessedQuestions">
                                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                </svg>
                            </span>
                            <span wire:loading.remove wire:target="submitProcessedQuestions">Submit to Database</span>
                            <span wire:loading wire:target="submitProcessedQuestions">Submitting...</span>
                        </button>

                        <a wire:navigate href="{{ route('questions.index') }}"
                           class="text-sm font-semibold text-gray-500 hover:text-gray-800 dark:text-gray-400 dark:hover:text-white transition ml-2 px-4 py-2 hover:bg-white dark:hover:bg-gray-800 rounded-lg border border-transparent hover:border-gray-200 dark:hover:border-gray-700">
                            Cancel
                        </a>

                        @if(! empty($processedQuestions))
                            <span class="ml-auto inline-flex items-center gap-2 text-sm text-green-700 dark:text-green-400 font-bold bg-green-50 dark:bg-green-900/30 px-4 py-2 rounded-xl border border-green-200 dark:border-green-800 shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ count($processedQuestions) }}টি প্রশ্ন Ready
                            </span>
                        @endif
                    </div>

                    {{-- Global processedQuestions error --}}
                    @error('processedQuestions')
                    <div class="flex items-center gap-3 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 px-5 py-4 shadow-sm">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-bold text-red-800 dark:text-red-300">{{ $message }}</p>
                    </div>
                    @enderror

                    {{-- OCR Loading Indicator --}}
                    <div wire:loading wire:target="processQuestions"
                         class="flex items-center gap-4 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 px-5 py-4 shadow-sm">
                        <svg class="w-6 h-6 animate-spin text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        <div>
                            <p class="text-base font-bold text-indigo-800 dark:text-indigo-300">
                                @if($sourceFile && trim($rawText) === '')
                                    Google Vision AI দিয়ে বাংলা OCR করা হচ্ছে...
                                @else
                                    প্রশ্ন প্রসেস করা হচ্ছে...
                                @endif
                            </p>
                            <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400 mt-0.5">
                                একটু অপেক্ষা করুন, সাধারণত ১০-৩০ সেকেন্ড লাগে।
                            </p>
                        </div>
                    </div>

                    {{-- ── Processed Questions Review ── --}}
                    @if(! empty($processedQuestions))
                        <div wire:key="processed-questions-card" class="rounded-2xl border border-indigo-200 dark:border-indigo-800 shadow-sm overflow-hidden bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 transition">
                            <div class="px-5 py-4 bg-indigo-100/50 dark:bg-indigo-900/50 border-b border-indigo-200 dark:border-indigo-800 flex items-center justify-between">
                                <h2 class="text-base font-bold text-indigo-900 dark:text-indigo-200 flex items-center gap-2">
                                    <div class="p-1.5 bg-indigo-200 dark:bg-indigo-800/50 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </div>
                                    Processed প্রশ্ন — টেক্সট সম্পাদনা ও সঠিক উত্তর চিহ্নিত করুন
                                </h2>
                                <span class="text-sm bg-indigo-200 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-200 px-3 py-1 rounded-full font-bold shadow-sm border border-indigo-300 dark:border-indigo-700">
                                    {{ count($processedQuestions) }}টি প্রশ্ন
                                </span>
                            </div>

                            <div class="px-5 py-3 bg-amber-100/50 dark:bg-amber-900/30 border-b border-amber-200 dark:border-amber-800/40 flex items-center gap-2 text-sm text-amber-800 dark:text-amber-400 font-medium">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                প্রতিটি প্রশ্নের সঠিক উত্তরটির পাশে <strong class="mx-1 px-2 py-0.5 bg-green-100 dark:bg-green-800 border border-green-300 dark:border-green-700 text-green-800 dark:text-green-200 rounded-md shadow-sm">✓ সঠিক</strong> বাটন ক্লিক করুন। এডিট করতে লেখার ওপর ক্লিক করুন।
                            </div>

                            {{-- 🌟 Alpine.js MutationObserver Container for Global KaTeX Re-render 🌟 --}}
                            <div class="p-5 space-y-5 max-h-[700px] overflow-y-auto" id="processed-questions-container"
                                 x-data="{
                                     init() {
                                         let timeout;
                                         const renderMath = () => {
                                             if (window.renderKatex) {
                                                 window.renderKatex();
                                             }
                                         };

                                         setTimeout(renderMath, 300);

                                         const observer = new MutationObserver((mutations) => {
                                             const isKatex = mutations.some(m =>
                                                 (m.target && m.target.className && typeof m.target.className === 'string' && m.target.className.includes('katex')) ||
                                                 (m.addedNodes.length > 0 && m.addedNodes[0].className && typeof m.addedNodes[0].className === 'string' && m.addedNodes[0].className.includes('katex'))
                                             );

                                             if (!isKatex) {
                                                 clearTimeout(timeout);
                                                 timeout = setTimeout(renderMath, 150);
                                             }
                                         });

                                         observer.observe(this.$el, { childList: true, subtree: true });
                                     }
                                 }">

                                @foreach($processedQuestions as $questionIndex => $question)
                                    @php
                                        $hasCorrect = collect($question['options'])->contains('is_correct', true);
                                        $optionLabels = ['ক', 'খ', 'গ', 'ঘ'];
                                    @endphp
                                    <div @class([
                                        'p-5 rounded-xl border bg-white dark:bg-gray-950 shadow-sm space-y-4 transition-all',
                                        'border-green-400 dark:border-green-700 ring-2 ring-green-100 dark:ring-green-900' => $hasCorrect,
                                        'border-indigo-200 dark:border-indigo-800 hover:border-indigo-300 dark:hover:border-indigo-700' => ! $hasCorrect,
                                    ])>

                                        {{-- 🌟 Question Title input with INLINE EDIT & PREVIEW --}}
                                        <div class="flex items-start gap-3">
                                            <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 text-sm font-extrabold flex items-center justify-center mt-1 border border-indigo-200 dark:border-indigo-800">
                                                {{ $questionIndex + 1 }}
                                            </span>

                                            <div x-data="{
                                                isEditing: false,
                                                text: @entangle('processedQuestions.'.$questionIndex.'.title'),
                                                init() {
                                                    this.$watch('text', () => { if(!this.isEditing) this.renderMath() });
                                                    setTimeout(() => { if(!this.isEditing) this.renderMath() }, 100);
                                                },
                                                renderMath() {
                                                    if(window.renderKatex) {
                                                        this.$nextTick(() => {
                                                            window.renderKatex();
                                                        });
                                                    }
                                                }
                                            }" class="w-full flex-1">

                                                <div x-show="!isEditing"
                                                     @click="isEditing = true; $nextTick(() => $refs.input.focus())"
                                                     x-ref="display"
                                                     x-html="text || '<span class=\'text-gray-400\'>শিরোনাম লিখুন... (ক্লিক করুন)</span>'"
                                                     class="block w-full rounded-xl border border-transparent hover:border-indigo-300 dark:hover:border-indigo-700 hover:bg-gray-50 dark:hover:bg-gray-800 px-4 py-2 text-base font-semibold transition cursor-text min-h-[44px]">
                                                </div>

                                                <input x-show="isEditing"
                                                       x-ref="input"
                                                       @blur="isEditing = false; renderMath()"
                                                       @keydown.enter="isEditing = false; renderMath()"
                                                       type="text"
                                                       x-model="text"
                                                       class="block w-full rounded-xl border border-indigo-500 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-base font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition font-['Noto_Serif_Bengali',_serif]"
                                                       placeholder="প্রশ্নটি এখানে লিখুন...">
                                            </div>

                                            @if($hasCorrect)
                                                <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-sm text-green-700 dark:text-green-400 font-bold bg-green-100 dark:bg-green-900/40 border border-green-300 dark:border-green-700 px-3 py-2 rounded-lg mt-0.5 shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    চিহ্নিত
                                                </span>
                                            @else
                                                <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-sm text-red-700 dark:text-red-400 font-bold bg-red-100 dark:bg-red-900/40 border border-red-300 dark:border-red-700 px-3 py-2 rounded-lg mt-0.5 shadow-sm animate-pulse">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                    চিহ্নিত নেই
                                                </span>
                                            @endif
                                        </div>

                                        {{-- 🌟 Smart Duplicate Warning --}}
                                        @if(!empty($question['is_duplicate']))
                                            <div class="flex items-center justify-between ml-11 mb-2 mt-[-0.25rem] px-3 py-2 text-xs font-semibold rounded-lg bg-orange-100 text-orange-800 border border-orange-200 dark:bg-orange-900/40 dark:text-orange-300 dark:border-orange-800">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                    এই প্রশ্নটি আপনার ডাটাবেজে আগে থেকেই আছে!
                                                </div>
                                                <button type="button" wire:click="removeProcessedQuestion({{ $questionIndex }})" title="বাতিল করুন" class="flex items-center justify-center p-1 rounded-md text-orange-600 hover:text-white hover:bg-orange-600 dark:text-orange-400 dark:hover:bg-orange-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endif

                                        {{-- 🌟 Dynamic Tags Input --}}
                                        <div x-data="{
                                            tags: @entangle('processedQuestions.'.$questionIndex.'.tags'),
                                            newTag: '',
                                            addTag() {
                                                let t = this.newTag.trim();
                                                if (t !== '') {
                                                    // Initialize if null
                                                    if (!Array.isArray(this.tags)) this.tags = [];
                                                    if (!this.tags.includes(t)) {
                                                        this.tags.push(t);
                                                    }
                                                }
                                                this.newTag = '';
                                            },
                                            removeTag(index) {
                                                this.tags.splice(index, 1);
                                            }
                                        }" class="ml-11 mb-2 mt-[-0.25rem]">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <template x-for="(tag, index) in tags" :key="index">
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 dark:bg-indigo-900/40 dark:text-indigo-300 rounded-md border border-indigo-200 dark:border-indigo-800">
                                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                                        <span x-text="tag"></span>
                                                        <button type="button" @click="removeTag(index)" class="hover:text-red-600 focus:outline-none transition-colors ml-0.5">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </span>
                                                </template>
                                                
                                                <div class="relative flex items-center">
                                                    <input type="text" 
                                                           x-model="newTag" 
                                                           @keydown.enter.prevent="addTag()" 
                                                           @blur="addTag()"
                                                           list="allTagsList"
                                                           placeholder="+ নতুন ট্যাগ" 
                                                           class="w-36 text-xs px-2.5 py-1 text-gray-700 dark:text-gray-300 border border-dashed border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 hover:bg-white focus:bg-white dark:bg-gray-900/50 dark:hover:bg-gray-800 dark:focus:bg-gray-800 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all outline-none">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- 🌟 AI Explanation Preview --}}
                                        @if(!empty($question['explanation']))
                                            <div class="ml-11 mb-3 mt-1 p-2.5 rounded-lg bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/10 dark:border-emerald-900/30">
                                                <div class="flex items-start gap-2">
                                                    <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <p class="text-xs text-emerald-800 dark:text-emerald-200 leading-relaxed">
                                                        <span class="font-semibold block mb-0.5">ব্যাখ্যা:</span>
                                                        {{ $question['explanation'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- 🌟 Options with INLINE EDIT & PREVIEW --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-11">
                                            @foreach($question['options'] as $optionIndex => $option)
                                                @php $isCorrect = (bool) ($option['is_correct'] ?? false); @endphp
                                                <div @class([
                                                    'flex items-center gap-3 rounded-xl border px-4 py-2 transition-all group',
                                                    'border-green-400 dark:border-green-600 bg-green-50 dark:bg-green-900/30 shadow-sm' => $isCorrect,
                                                    'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:border-indigo-300 dark:hover:border-indigo-600' => ! $isCorrect,
                                                ])>
                                                    <span @class([
                                                        'flex-shrink-0 w-7 h-7 rounded-full text-sm font-bold flex items-center justify-center',
                                                        'bg-green-500 text-white shadow-sm' => $isCorrect,
                                                        'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600' => ! $isCorrect,
                                                    ])>
                                                        {{ $optionLabels[$optionIndex] ?? ($optionIndex + 1) }}
                                                    </span>

                                                    <div x-data="{
                                                        isEditing: false,
                                                        text: @entangle('processedQuestions.'.$questionIndex.'.options.'.$optionIndex.'.option_text'),
                                                        init() {
                                                            this.$watch('text', () => { if(!this.isEditing) this.renderMath() });
                                                            setTimeout(() => { if(!this.isEditing) this.renderMath() }, 100);
                                                        },
                                                        renderMath() {
                                                            if(window.renderKatex) {
                                                                this.$nextTick(() => {
                                                                    window.renderKatex();
                                                                });
                                                            }
                                                        }
                                                    }" class="flex-1 min-w-0 flex flex-col justify-center">

                                                        <div x-show="!isEditing"
                                                             @click.prevent="isEditing = true; $nextTick(() => $refs.input.focus())"
                                                             x-ref="display"
                                                             x-html="text || '<span class=\'text-gray-400\'>Option ' + ({{ $optionIndex }} + 1) + '</span>'"
                                                             class="w-full text-sm md:text-base text-gray-900 dark:text-gray-100 font-medium overflow-x-auto min-h-[28px] cursor-text px-2 py-1 rounded border border-transparent hover:border-indigo-300 dark:hover:border-indigo-700 transition">
                                                        </div>

                                                        <input x-show="isEditing"
                                                               x-ref="input"
                                                               @blur="isEditing = false; renderMath()"
                                                               @keydown.enter="isEditing = false; renderMath()"
                                                               type="text"
                                                               x-model="text"
                                                               class="w-full bg-white dark:bg-gray-900 border border-indigo-500 rounded px-2 py-1.5 text-sm md:text-base text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-['Noto_Serif_Bengali',_serif] p-0 font-medium"
                                                               placeholder="Option {{ $optionIndex + 1 }}">
                                                    </div>

                                                    <button type="button"
                                                            wire:click="setCorrectOption({{ $questionIndex }}, {{ $optionIndex }})"
                                                            title="{{ $isCorrect ? 'সঠিক উত্তর হিসেবে চিহ্নিত' : 'সঠিক উত্তর হিসেবে চিহ্নিত করুন' }}"
                                                        @class([
                                                            'flex-shrink-0 inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1.5 rounded-lg transition-all',
                                                            'bg-green-500 text-white shadow-md cursor-default border border-green-600 dark:border-green-500' => $isCorrect,
                                                            'bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:border-green-400 hover:text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30' => ! $isCorrect,
                                                        ])>
                                                        @if($isCorrect)
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                            সঠিক
                                                        @else
                                                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                            চিহ্নিত করুন
                                                        @endif
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── Right Column: Settings Sidebar ── --}}
                <div class="w-full lg:w-[350px] xl:w-[400px] shrink-0 space-y-6 order-1 lg:order-2 lg:sticky lg:top-24">

                                        {{-- Categorization Card --}}
                    <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-7 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-6">
                        <h3 class="text-sm font-bold text-gray-950 dark:text-white uppercase tracking-wider flex items-center gap-2.5 pb-3 border-b dark:border-gray-800">
                            <div class="p-1.5 bg-indigo-100 dark:bg-indigo-950 rounded-md text-indigo-600 dark:text-indigo-400">
                                <svg class="size-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M496 128v16a8 8 0 0 1-8 8h-24v12c0 6.627-5.373 12-12 12H60c-6.627 0-12-5.373-12-12v-12H24a8 8 0 0 1-8-8v-16a8 8 0 0 1 8-8h22.758c5.441-26.657 20.301-49.851 40.718-67.653C104.992 40.404 115.309 32 128 32h256c12.691 0 23.008 8.404 40.524 20.347C444.941 70.149 459.801 93.343 465.242 120H488a8 8 0 0 1 8 8zM176 80c-8.837 0-16 7.163-16 16v16h256v-16c0-8.837-7.163-16-16-16H176zm-56 304h272v108c0 6.627-5.373 12-12 12H132c-6.627 0-12-5.373-12-12V384zm316-208H76c-6.627 0-12 5.373-12 12v152c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12V188c0-6.627-5.373-12-12-12z"></path></svg>
                            </div>
                            Categorization
                        </h3>

                        <div class="space-y-5">
                            <div wire:ignore wire:key="subject-select-bulk">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Subject <span class="text-red-500">*</span></label>
                                <select id="subject" class="w-full">
                            <option value=""></option>
                                    
                                    @foreach($subjects as $s) <option value="{{ $s->id }}" @selected($s->id == $subject_id)>{{ $s->name }}</option> @endforeach
                                </select>
                                @error('subject_id')<span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>@enderror
                            </div>

                            <div wire:ignore wire:key="subsubject-select-bulk">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Chapter / Paper</label>
                                <select id="chapter" class="w-full">
                            <option value=""></option>
                                    
                                    @foreach($chapters as $ss) <option value="{{ $ss->id }}" @selected($ss->id == $chapter_id)>{{ $ss->name }}</option> @endforeach
                                </select>
                            </div>

                            <div wire:ignore wire:key="topic-select-bulk">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Topic</label>
                                <select id="topic" class="w-full">
                            <option value=""></option>
                                    
                                    @foreach($topics as $c) <option value="{{ $c->id }}" @selected($c->id == $topic_id)>{{ $c->name }}</option> @endforeach
                                </select>
                            </div>

                            <div wire:ignore wire:key="class-select-bulk">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Target Audience (Classes) <span class="text-red-500">*</span></label>
                                <select id="academic_class" class="w-full" multiple>
                            <option value=""></option>
                                    
                                    @foreach($classes as $class) <option value="{{ $class->id }}" @selected(in_array($class->id, $academic_class_ids))>{{ $class->name }}</option> @endforeach
                                </select>
                                @error('academic_class_ids')<span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Settings Card --}}
                    <div wire:key="settings-card" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm space-y-5">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2 uppercase tracking-wider border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="p-1.5 bg-blue-100 dark:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            Settings
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Difficulty</label>
                                <select wire:model="difficulty" class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 transition shadow-sm">
                                    <option value="easy">Easy 😊</option>
                                    <option value="medium">Medium 😐</option>
                                    <option value="hard">Hard 🤯</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Marks</label>
                                <div class="relative">
                                    <input type="number" min="0.25" step="0.25" wire:model="marks" class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition shadow-sm pr-12">
                                    <span class="absolute right-4 top-2.5 text-gray-400 font-medium text-sm">Pts</span>
                                </div>
                                @error('marks') <p class="text-xs text-red-500 font-medium mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Image/PDF Upload Card (🌟 Alpine.js + wire:ignore applied to prevent reload) --}}
                    <div wire:key="image-upload-card" class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-900 shadow-sm space-y-4 transition hover:shadow-md">
                        <label class="block text-sm font-bold text-gray-800 dark:text-gray-200 flex items-center gap-2 border-b border-indigo-100 dark:border-indigo-800 pb-3">
                            <div class="p-1.5 bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                            </div>
                            ইমেজ / PDF আপলোড <span class="text-xs font-medium text-indigo-600 bg-indigo-100 dark:bg-indigo-900/50 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800 px-2 py-0.5 rounded-full ml-auto">Optional</span>
                        </label>

                        {{-- 🌟 Added wire:ignore so this section NEVER reloads when changing categories 🌟 --}}
                        <div wire:ignore>
                            <div x-data="{
                                    previewUrl: null,
                                    fileName: null,
                                    fileSize: null,
                                    isPdf: false,
                                    handleFileChange(event) {
                                        const file = event.target.files[0];
                                        if (!file) return;

                                        this.fileName = file.name;
                                        this.fileSize = (file.size / 1024).toFixed(1);
                                        this.isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

                                        if (!this.isPdf) {
                                            const reader = new FileReader();
                                            reader.onload = (e) => { this.previewUrl = e.target.result; };
                                            reader.readAsDataURL(file);
                                        } else {
                                            this.previewUrl = null;
                                        }

                                        @this.upload('sourceFile', file);
                                    }
                                }" class="w-full">

                                <label for="sourceFileInput"
                                       class="group relative flex flex-col items-center justify-center w-full rounded-xl border-2 border-dashed cursor-pointer transition-all bg-white dark:bg-gray-950 shadow-sm px-4 py-6 text-center"
                                       :class="(previewUrl || isPdf) ? 'border-indigo-400 dark:border-indigo-500' : 'border-gray-300 dark:border-gray-700 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10'">

                                    {{-- Uploaded State (PDF) --}}
                                    <div x-show="isPdf" style="display: none;" class="flex flex-col items-center gap-2">
                                        <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/50 flex items-center justify-center text-red-600 dark:text-red-400 mb-1 border border-red-200 dark:border-red-800">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate max-w-[200px]" x-text="fileName"></p>
                                        <p class="text-xs text-gray-600 font-bold border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 px-2 py-0.5 rounded-md shadow-sm">PDF • <span x-text="fileSize"></span> KB</p>
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-bold mt-2 bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1 rounded-lg border border-indigo-200 dark:border-indigo-800">Change File</span>
                                    </div>

                                    {{-- Uploaded State (Image) --}}
                                    <div x-show="previewUrl && !isPdf" style="display: none;" class="w-full space-y-3 flex flex-col items-center">
                                        <img :src="previewUrl" class="h-32 object-contain rounded-lg border border-gray-300 dark:border-gray-700 shadow-sm bg-gray-50 dark:bg-gray-900 p-1" alt="Preview">
                                        <span class="text-xs text-indigo-600 dark:text-indigo-400 font-bold bg-indigo-50 dark:bg-indigo-900/30 px-3 py-1.5 rounded-lg border border-indigo-200 dark:border-indigo-800">Change Image</span>
                                    </div>

                                    {{-- Empty State --}}
                                    <div x-show="!previewUrl && !isPdf" class="flex flex-col items-center gap-2">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 flex items-center justify-center mb-1 group-hover:scale-110 transition-transform">
                                            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Click or Drag & Drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 font-semibold">JPG, PNG, WebP, PDF (Max 10MB)</p>
                                    </div>

                                    <input id="sourceFileInput" type="file" @change="handleFileChange" accept="image/jpeg,image/png,image/webp,application/pdf,.pdf" class="hidden">
                                </label>
                            </div>
                        </div>

                        <div wire:loading wire:target="sourceFile" class="flex justify-center items-center gap-2 text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>
                            Uploading...
                        </div>
                        @error('sourceFile') <p class="text-xs font-bold text-red-600 text-center bg-red-50 dark:bg-red-950/50 p-2 rounded-lg">{{ $message }}</p> @enderror

                        <div class="flex items-center justify-center gap-1.5 text-[11px] font-bold text-indigo-700 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/30 py-2 rounded-lg border border-indigo-200 dark:border-indigo-800/50 uppercase tracking-wide shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            Powered By Google Vision AI
                        </div>
                    </div>

                    {{-- Metadata Card (Tags & Audience) --}}
                    <div wire:key="metadata-card" class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm space-y-5">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2 uppercase tracking-wider border-b border-gray-100 dark:border-gray-800 pb-3">
                            <div class="p-1.5 bg-green-100 dark:bg-green-900/50 text-green-600 dark:text-green-400 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                            </div>
                            Metadata
                        </h3>

                        <div wire:ignore class="relative z-20">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tags <span class="text-indigo-400 font-medium text-xs ml-1">(Type & Enter)</span></label>
                            <select id="bulk_tags" class="w-full" multiple>
                                @foreach($allTags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $tagIds) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <datalist id="allTagsList">
        @foreach($allTags as $tag)
            <option value="{{ $tag->name }}">
        @endforeach
    </datalist>
</div>

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@push('scripts')
    {{-- TomSelect CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    {{-- MathJax is now loaded globally via head.blade.php --}}
    <!-- CKEditor 4 -->
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

    <script>
        function wrapMathForCKEditor(html) {
            return window.wrapMathForCKEditor ? window.wrapMathForCKEditor(html) : html;
        }

        if (!window.hasRegisteredBulkUploadEvents) {
            
            window.updateLivewire = (property, value) => {
                if (Array.isArray(value)) {
                    @this.set(property, value);
                } else if (value === '' || value === null) {
                    @this.set(property, null);
                } else {
                    @this.set(property, value);
                }
            };

            window.initBulkUploadTomSelect = () => {
                // Tags
                if (window.bulkTsTags) { window.bulkTsTags.destroy(); window.bulkTsTags = null; }
                const tagsEl = document.getElementById('bulk_tags');
                if (tagsEl && typeof TomSelect !== 'undefined') {
                    window.bulkTsTags = new TomSelect(tagsEl, {
                        plugins: ['remove_button', 'dropdown_input'],
                        persist: false,
                        create: true,
                        maxOptions: 50,
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        onChange: (v) => @this.set('tagIds', v),
                    });
                }

                // Categorization
                if (typeof TomSelect !== 'undefined') {
                    const tsConfig = {
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        maxOptions: 50,
                        controlInput: '<input>',
                        render: {
                            option: function(data, escape) {
                                return '<div class="py-2 px-3 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">' + escape(data.text) + '</div>';
                            },
                            item: function(data, escape) {
                                return '<div class="py-1 px-1">' + escape(data.text) + '</div>';
                            }
                        }
                    };

                    const tsMultiConfig = {
                        ...tsConfig,
                        plugins: ['remove_button'],
                    };

                    const classEl = document.getElementById('academic_class');
                    if (classEl && !classEl.tomselect) window.tsClass = new TomSelect(classEl, {...tsMultiConfig, placeholder: '-- Select Class --', onChange: (v) => window.updateLivewire('academic_class_ids', v) });

                    const subjectEl = document.getElementById('subject');
                    if (subjectEl && !subjectEl.tomselect) window.tsSubject = new TomSelect(subjectEl, {...tsConfig, placeholder: '-- Select Subject --', onChange: (v) => window.updateLivewire('subject_id', v) });

                    const chapterEl = document.getElementById('chapter');
                    if (chapterEl && !chapterEl.tomselect) window.tsChapter = new TomSelect(chapterEl, {...tsConfig, placeholder: '-- Select Chapter --', onChange: (v) => window.updateLivewire('chapter_id', v) });

                    const topicEl = document.getElementById('topic');
                    if (topicEl && !topicEl.tomselect) window.tsTopic = new TomSelect(topicEl, {...tsConfig, placeholder: '-- Select Topic --', onChange: (v) => window.updateLivewire('topic_id', v) });
                }
            };

            window.addEventListener('subjectsUpdated', e => {
                if (window.tsSubject) {
                    window.tsSubject.clear(true);
                    window.tsSubject.clearOptions();
                                        window.tsSubject.addOptions(e.detail.subjects);
                    window.tsSubject.refreshOptions(false);
                }
            });

            window.addEventListener('chaptersUpdated', e => {
                if (window.tsChapter) {
                    window.tsChapter.clear(true);
                    window.tsChapter.clearOptions();
                                        window.tsChapter.addOptions(e.detail.chapters);
                    window.tsChapter.refreshOptions(false);
                }
            });

            window.addEventListener('topicsUpdated', e => {
                if (window.tsTopic) {
                    window.tsTopic.clear(true);
                    window.tsTopic.clearOptions();
                                        window.tsTopic.addOptions(e.detail.topics);
                    window.tsTopic.refreshOptions(false);
                }
            });

            window.initBulkUploadEditor = () => {
                if (window.initGlobalCkEditor) {
                    window.initGlobalCkEditor('raw_text_editor', @this, 'rawText');
                }
            };

            window.initBulkUploadComponents = () => {
                window.initBulkUploadTomSelect();
                window.initBulkUploadEditor();
            };

            window.addEventListener('update-editor', event => {
                let text = event.detail.text || event.detail[0].text;
                let htmlText = text.replace(/\n/g, '<br>');
                if (CKEDITOR && CKEDITOR.instances['raw_text_editor']) {
                    CKEDITOR.instances['raw_text_editor'].setData(wrapMathForCKEditor(htmlText));
                }
            });

            document.addEventListener('livewire:load', () => setTimeout(window.initBulkUploadComponents, 100));
            document.addEventListener('livewire:navigated', () => setTimeout(window.initBulkUploadComponents, 100));

            document.addEventListener('livewire:navigating', () => {
                if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances['raw_text_editor']) {
                    try { CKEDITOR.instances['raw_text_editor'].destroy(true); } catch(e) {}
                }
                if (window.bulkTsTags) { window.bulkTsTags.destroy(); window.bulkTsTags = null; }
                if (window.tsClass) { window.tsClass.destroy(); window.tsClass = null; }
                if (window.tsSubject) { window.tsSubject.destroy(); window.tsSubject = null; }
                if (window.tsChapter) { window.tsChapter.destroy(); window.tsChapter = null; }
                if (window.tsTopic) { window.tsTopic.destroy(); window.tsTopic = null; }
            });

            window.hasRegisteredBulkUploadEvents = true;
        } else {
            setTimeout(() => {
                if (window.initBulkUploadComponents) window.initBulkUploadComponents();
            }, 100);
        }
    </script>
@endpush

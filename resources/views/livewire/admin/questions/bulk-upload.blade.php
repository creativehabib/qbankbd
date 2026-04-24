<div class="max-w-5xl mx-auto">
    {{-- Flash Messages --}}
    @if(session()->has('success'))
        <div class="mb-4 flex items-center gap-3 rounded-lg bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 px-4 py-3">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-white dark:from-indigo-900/20 dark:to-gray-800">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">প্রশ্ন ছবি/PDF/টেক্সট থেকে Bulk Upload</h1>
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-medium text-indigo-600 dark:text-indigo-400">Step 1:</span> MCQ টেক্সট দিন অথবা ইমেজ/PDF আপলোড করুন →
                        <strong>Process Questions</strong> ক্লিক করুন।
                        <span class="font-medium text-indigo-600 dark:text-indigo-400">Step 2:</span> সঠিক উত্তর চিহ্নিত করুন →
                        <strong>Submit to Database</strong> দিন।
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- ── Row 1: Class & Subject ── --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        শ্রেণি <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="academic_class_id"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('academic_class_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        বিষয় <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="subject_id"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        @disabled(! $academic_class_id)>
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">অধ্যায় (ঐচ্ছিক)</label>
                    <select wire:model.live="chapter_id"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        @disabled(! $subject_id)>
                        <option value="">-- Select Chapter --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">টপিক (ঐচ্ছিক)</label>
                    <select wire:model="topic_id"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        @disabled(! $chapter_id)>
                        <option value="">-- Select Topic --</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ── Row 2: Difficulty, Marks, Source File ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Difficulty <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="difficulty"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="easy">Easy (সহজ)</option>
                        <option value="medium">Medium (মাঝারি)</option>
                        <option value="hard">Hard (কঠিন)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Marks <span class="text-red-500">*</span>
                    </label>
                    <input type="number" min="0.25" step="0.25" wire:model="marks"
                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    @error('marks')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ── Source File Upload (Image + PDF) ── --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        ইমেজ / PDF আপলোড
                        <span class="ml-1 text-xs font-normal text-gray-400">(ঐচ্ছিক)</span>
                    </label>

                    {{-- Drop Zone --}}
                    <label for="sourceFileInput"
                           class="group relative flex flex-col items-center justify-center w-full rounded-lg border-2 border-dashed cursor-pointer transition-all
                                  @if($sourceFile) border-indigo-400 dark:border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20
                                  @else border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/30 hover:border-indigo-400 dark:hover:border-indigo-500 hover:bg-indigo-50/50 dark:hover:bg-indigo-900/10 @endif
                                  min-h-[90px] px-3 py-3">

                        @if($sourceFile)
                            @php
                                $ext = strtolower($sourceFile->getClientOriginalExtension());
                                $isPdf = $ext === 'pdf';
                            @endphp

                            @if($isPdf)
                                {{-- PDF Preview --}}
                                <div class="flex flex-col items-center gap-1.5 w-full">
                                    <div class="flex items-center gap-2 w-full">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-800 dark:text-gray-200 truncate">
                                                {{ $sourceFile->getClientOriginalName() }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                PDF • {{ number_format($sourceFile->getSize() / 1024, 1) }} KB
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-xs text-indigo-600 dark:text-indigo-400">পরিবর্তন করতে ক্লিক করুন</p>
                                </div>
                            @else
                                {{-- Image Preview --}}
                                <div class="w-full space-y-1.5">
                                    <div class="rounded-md overflow-hidden border border-gray-200 dark:border-gray-600 max-h-24">
                                        <img src="{{ $sourceFile->temporaryUrl() }}" class="w-full h-24 object-cover" alt="Preview">
                                    </div>
                                    <p class="text-center text-xs text-indigo-600 dark:text-indigo-400">পরিবর্তন করতে ক্লিক করুন</p>
                                </div>
                            @endif
                        @else
                            {{-- Empty State --}}
                            <div class="flex flex-col items-center gap-1 text-center">
                                <svg class="w-7 h-7 text-gray-400 dark:text-gray-500 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                                    ক্লিক করুন বা ফাইল ড্রপ করুন
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    JPG, PNG, WebP, PDF — সর্বোচ্চ 10MB
                                </p>
                            </div>
                        @endif

                        <input id="sourceFileInput"
                               type="file"
                               wire:model="sourceFile"
                               accept="image/jpeg,image/png,image/webp,application/pdf,.pdf"
                               class="sr-only">
                    </label>

                    {{-- Upload Progress --}}
                    <div wire:loading wire:target="sourceFile" class="mt-1.5 flex items-center gap-2 text-xs text-indigo-600 dark:text-indigo-400">
                        <svg class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                        আপলোড হচ্ছে...
                    </div>

                    @error('sourceFile')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Info badge: Google Vision --}}
                    <div class="mt-1.5 flex items-center gap-1.5 text-xs text-gray-400 dark:text-gray-500">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        বাংলা OCR: Google Vision AI — ইমেজ ও PDF উভয়ই সাপোর্টেড
                    </div>
                </div>
            </div>

            {{-- ── Exam Categories ── --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Target Audience <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 p-3 rounded-lg bg-gray-50 dark:bg-gray-900/40 border border-gray-200 dark:border-gray-700">
                    @foreach($allExamCategories as $category)
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                            <input type="checkbox" value="{{ $category->id }}" wire:model="exam_category_ids"
                                   class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 bg-white dark:bg-gray-700">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('exam_category_ids')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Raw Text Textarea ── --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        OCR / Raw প্রশ্ন টেক্সট
                    </label>
                    <span class="text-xs text-gray-400 dark:text-gray-500">Process করার পর এখানেই formatted প্রশ্ন দেখাবে</span>
                </div>
                <textarea wire:model="rawText" rows="10"
                          class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-['Noto_Serif_Bengali',_serif] leading-relaxed"
                          placeholder="১. শব্দটির অর্থ কী?&#10;(ক) আলো&#10;(খ) জল&#10;(গ) বায়ু&#10;(ঘ) মাটি&#10;&#10;২. ..."></textarea>
                @error('rawText')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-wrap items-center gap-3 pt-1">

                {{-- Process Button --}}
                <button type="button" wire:click="processQuestions"
                        wire:loading.attr="disabled" wire:target="processQuestions,sourceFile"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-amber-500 hover:bg-amber-600 active:bg-amber-700 text-white text-sm font-medium shadow-sm transition disabled:opacity-60 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="processQuestions">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </span>
                    <span wire:loading wire:target="processQuestions">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="processQuestions">Process Questions</span>
                    <span wire:loading wire:target="processQuestions">
                        @if($sourceFile && trim($rawText) === '')
                            OCR চলছে...
                        @else
                            Processing...
                        @endif
                    </span>
                </button>

                {{-- Submit Button --}}
                <button type="button" wire:click="submitProcessedQuestions"
                        wire:loading.attr="disabled" wire:target="submitProcessedQuestions"
                    @class([
                        'inline-flex items-center gap-2 px-5 py-2.5 rounded-lg text-white text-sm font-medium shadow-sm transition',
                        'bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800' => ! empty($processedQuestions),
                        'bg-gray-300 dark:bg-gray-600 cursor-not-allowed opacity-60' => empty($processedQuestions),
                    ])
                    @disabled(empty($processedQuestions))>
                    <span wire:loading.remove wire:target="submitProcessedQuestions">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span wire:loading wire:target="submitProcessedQuestions">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                        </svg>
                    </span>
                    <span wire:loading.remove wire:target="submitProcessedQuestions">Submit to Database</span>
                    <span wire:loading wire:target="submitProcessedQuestions">Submitting...</span>
                </button>

                <a wire:navigate href="{{ route('questions.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition ml-1">
                    Cancel
                </a>

                @if(! empty($processedQuestions))
                    <span class="ml-auto inline-flex items-center gap-1.5 text-sm text-green-700 dark:text-green-400 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ count($processedQuestions) }}টি প্রশ্ন Ready
                    </span>
                @endif
            </div>

            {{-- Global processedQuestions error --}}
            @error('processedQuestions')
            <div class="flex items-center gap-2 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 px-4 py-3">
                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-red-700 dark:text-red-300">{{ $message }}</p>
            </div>
            @enderror

            {{-- OCR Loading Indicator (process চলার সময়) --}}
            <div wire:loading wire:target="processQuestions"
                 class="flex items-center gap-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 px-4 py-3">
                <svg class="w-4 h-4 animate-spin text-indigo-600 dark:text-indigo-400 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                <div>
                    <p class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                        @if($sourceFile && trim($rawText) === '')
                            Google Vision AI দিয়ে বাংলা OCR করা হচ্ছে...
                        @else
                            প্রশ্ন প্রসেস করা হচ্ছে...
                        @endif
                    </p>
                    <p class="text-xs text-indigo-500 dark:text-indigo-400 mt-0.5">
                        একটু অপেক্ষা করুন, সাধারণত ১০-৩০ সেকেন্ড লাগে।
                    </p>
                </div>
            </div>

            {{-- ── Processed Questions Review ── --}}
            @if(! empty($processedQuestions))
                <div class="rounded-xl border border-indigo-100 dark:border-indigo-800/50 overflow-hidden">
                    <div class="px-4 py-3 bg-indigo-50 dark:bg-indigo-900/30 border-b border-indigo-100 dark:border-indigo-800/50 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-indigo-800 dark:text-indigo-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Processed প্রশ্ন — টেক্সট সম্পাদনা ও সঠিক উত্তর চিহ্নিত করুন
                        </h2>
                        <span class="text-xs bg-indigo-100 dark:bg-indigo-800 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-full font-medium">
                            {{ count($processedQuestions) }}টি প্রশ্ন
                        </span>
                    </div>

                    {{-- Legend --}}
                    <div class="px-4 py-2 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-800/40 flex items-center gap-2 text-xs text-amber-700 dark:text-amber-400">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        প্রতিটি প্রশ্নের সঠিক উত্তরটির পাশে <strong class="mx-1 text-green-700 dark:text-green-400">✓ সঠিক</strong> বাটন ক্লিক করুন। Submit এর আগে সব প্রশ্নে সঠিক উত্তর চিহ্নিত করা আবশ্যক।
                    </div>

                    <div class="p-4 space-y-4 max-h-[700px] overflow-y-auto">
                        @foreach($processedQuestions as $questionIndex => $question)
                            @php
                                $hasCorrect = collect($question['options'])->contains('is_correct', true);
                                $optionLabels = ['ক', 'খ', 'গ', 'ঘ'];
                            @endphp
                            <div @class([
                                'p-4 rounded-lg border bg-white dark:bg-gray-900/60 space-y-3 transition',
                                'border-green-300 dark:border-green-700 ring-1 ring-green-200 dark:ring-green-800' => $hasCorrect,
                                'border-red-200 dark:border-red-700' => ! $hasCorrect,
                            ])>
                                {{-- Question title row --}}
                                <div class="flex items-start gap-3">
                                    <span class="flex-shrink-0 w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 text-xs font-bold flex items-center justify-center mt-1">
                                        {{ $questionIndex + 1 }}
                                    </span>
                                    <input type="text"
                                           wire:model="processedQuestions.{{ $questionIndex }}.title"
                                           class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition font-['Noto_Serif_Bengali',_serif]"
                                           placeholder="প্রশ্নের শিরোনাম">

                                    {{-- Correct answer status badge --}}
                                    @if($hasCorrect)
                                        <span class="flex-shrink-0 inline-flex items-center gap-1 text-xs text-green-700 dark:text-green-400 font-medium bg-green-50 dark:bg-green-900/40 border border-green-200 dark:border-green-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            চিহ্নিত
                                        </span>
                                    @else
                                        <span class="flex-shrink-0 inline-flex items-center gap-1 text-xs text-red-600 dark:text-red-400 font-medium bg-red-50 dark:bg-red-900/40 border border-red-200 dark:border-red-700 px-2 py-1 rounded-full">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            চিহ্নিত নেই
                                        </span>
                                    @endif
                                </div>

                                {{-- Options --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 pl-9">
                                    @foreach($question['options'] as $optionIndex => $option)
                                        @php $isCorrect = (bool) ($option['is_correct'] ?? false); @endphp
                                        <div @class([
                                            'flex items-center gap-2 rounded-lg border px-3 py-2 transition group',
                                            'border-green-400 dark:border-green-600 bg-green-50 dark:bg-green-900/30' => $isCorrect,
                                            'border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-500' => ! $isCorrect,
                                        ])>
                                            {{-- Option label badge --}}
                                            <span @class([
                                                'flex-shrink-0 w-6 h-6 rounded-full text-xs font-bold flex items-center justify-center',
                                                'bg-green-500 text-white' => $isCorrect,
                                                'bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-300' => ! $isCorrect,
                                            ])>
                                                {{ $optionLabels[$optionIndex] ?? ($optionIndex + 1) }}
                                            </span>

                                            {{-- Option text input --}}
                                            <input type="text"
                                                   wire:model="processedQuestions.{{ $questionIndex }}.options.{{ $optionIndex }}.option_text"
                                                   class="flex-1 min-w-0 bg-transparent border-0 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-0 font-['Noto_Serif_Bengali',_serif] p-0"
                                                   placeholder="Option {{ $optionIndex + 1 }}">

                                            {{-- Correct answer toggle button --}}
                                            <button type="button"
                                                    wire:click="setCorrectOption({{ $questionIndex }}, {{ $optionIndex }})"
                                                    title="{{ $isCorrect ? 'সঠিক উত্তর হিসেবে চিহ্নিত' : 'সঠিক উত্তর হিসেবে চিহ্নিত করুন' }}"
                                                @class([
                                                    'flex-shrink-0 inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-md transition',
                                                    'bg-green-500 text-white cursor-default' => $isCorrect,
                                                    'bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-500 text-gray-500 dark:text-gray-400 hover:border-green-400 hover:text-green-600 dark:hover:text-green-400' => ! $isCorrect,
                                                ])>
                                                @if($isCorrect)
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    সঠিক
                                                @else
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    ✓ সঠিক
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
    </div>
</div>

{{-- Noto Serif Bengali font for proper Bangla rendering --}}
@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Bengali:wght@400;500;600&display=swap" rel="stylesheet">
@endpush

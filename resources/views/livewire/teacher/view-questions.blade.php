<div class="bangla flex lg:gap-5 justify-between">
    <div class="flex-1 max-w-4xl mx-auto">
        <!-- উপরের স্টিকি বার -->
        <div class="mb-2 sticky top-14 text-sm md:text-md flex gap-2 items-center bg-gray-50 rounded p-2 border justify-between z-10">
            <p class="bg-gray-200 px-2 py-1.5 rounded">
                <span class="hidden md:inline-block">Selected:</span> {{ count($selectedQuestions) }} / {{ $this->availableQuestions->count() }}
            </p>
            <a class="flex gap-1 items-center bg-gray-200 rounded hover:bg-gray-300 px-3 py-1.5" href="{{ route('questions.paper', ['qset' => $questionSet->id]) }}">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 576 512" height="1em" width="1em"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path></svg>
                <span>View Paper</span>
            </a>
            <button wire:click="saveSelection" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded">
                <span class="flex items-center gap-1"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="1em" width="1em"><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z"></path></svg> Save</span>
            </button>
        </div>

        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">{{ session('success') }}</div>
        @endif

        <div class="flex gap-2 justify-between my-4">
            <p class="p-2 rounded border line-clamp-1 truncate">টাইটেল - {{ $questionSet->name }}</p>
            @if (count($selectedQuestions) === $this->availableQuestions->count() && $this->availableQuestions->count() > 0)
                <button wire:click="toggleSelectAll" class="shrink-0 border px-3 py-1 rounded border-red-500 text-red-600 flex items-center gap-1 font-semibold text-sm">Deselect All</button>
            @else
                <button wire:click="toggleSelectAll" class="shrink-0 border px-2 rounded border-green-500 flex items-center gap-1 text-sm">Select All</button>
            @endif
        </div>

        <div class="text-center bg-yellow-50 p-1 rounded mb-6">প্রশ্নে ভুল পেলে রিপোর্ট করে প্রশ্নব্যাংক সমৃদ্ধ করুন ।</div>

        <div class="relative">
            @forelse ($this->availableQuestions as $question)
                <div wire:click="toggleSelection('{{ $question->id }}')"
                     class="bg-white rounded-lg border my-2.5 transition-all duration-150 cursor-pointer {{ in_array((string)$question->id, $selectedQuestions) ? 'border-green-500 border-x-8' : 'border-gray-200' }}">
                    <div class="p-2">
                        <div class="flex items-center justify-between mb-1">
                            <div class="mr-1">
                                <input type="checkbox" @if(in_array((string)$question->id, $selectedQuestions)) checked @endif class="hidden">
                            </div>
                            <div class="flex gap-2 items-center text-xs flex-wrap">
                                <span class="bg-gray-200 text-gray-700 px-2 py-0.5 rounded uppercase font-bold">{{ $question->question_type }}</span>
                                @if($question->difficulty) <span class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded-full">{{ $question->difficulty }}</span> @endif

                                @foreach($question->examCategories as $examCat)
                                    <span class="bg-purple-200 text-purple-800 px-2 py-0.5 rounded-full">{{ $examCat->name }}</span>
                                @endforeach

                                @foreach($question->tags as $tag)
                                    <span class="bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded-full">{{ $tag->name }}</span>
                                @endforeach

                                <button wire:click.stop="toggleExplanation({{ $question->id }})" class="shrink-0 bg-green-600 hover:bg-green-500 text-white rounded-full px-1.5 py-0.5 text-[10px]">ব্যাখ্যা</button>
                            </div>
                        </div>
                        <div class="p-1">
                            <div class="flex items-baseline flex-wrap">
                                <span class="mr-1">{{ $loop->iteration }}.</span>
                                <div class="flex-1">{!! $question->title !!}</div>
                            </div>

                            @php
                                $extraData = [];
                                if (!empty($question->extra_content)) {
                                    $extraData = is_string($question->extra_content) ? json_decode($question->extra_content, true) : $question->extra_content;
                                }
                                $mcqOptions = $extraData ?? [];
                                $cqParts = $extraData ?? [];
                            @endphp

                            @if(!empty($mcqOptions) && isset($mcqOptions[0]['option_text']))
                                <div class="grid gap-1 grid-cols-2 mt-2 ml-4">
                                    @foreach ($mcqOptions as $option)
                                        <div class="p-2 flex items-center gap-1 rounded-lg bg-gray-100 text-sm">
                                            <div class="flex items-center justify-center h-5 w-5 border rounded-full p-0.5 {{ (!empty($option['is_correct']) && $option['is_correct']) ? 'bg-gray-700 text-white border-gray-700' : 'border-gray-600' }}">{{ mb_chr(2453 + $loop->index) }}</div>
                                            <div>{!! $option['option_text'] ?? '' !!}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(!empty($cqParts) && isset($cqParts[0]['label']))
                                <div class="mt-3 space-y-2 ml-4">
                                    @foreach ($cqParts as $part)
                                        <div class="flex justify-between items-start bg-gray-50 p-2 rounded-lg border border-gray-200 text-sm">
                                            <div class="flex gap-2 items-baseline text-gray-800">
                                                <span class="font-bold text-gray-700">{{ $part['label'] ?? '' }}.</span>
                                                <div class="flex-1">{!! $part['text'] ?? '' !!}</div>
                                            </div>
                                            <span class="font-bold text-gray-600 shrink-0 bg-white border border-gray-200 px-2 py-0.5 rounded ml-3 shadow-sm">মান: {{ $part['marks'] ?? '' }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-2 text-green-700 rounded transition-all duration-300 {{ $showExplanationFor === $question->id ? 'max-h-screen opacity-100 bg-green-50 p-2' : 'max-h-0 opacity-0' }}">
                                @if($showExplanationFor === $question->id && $question->description)
                                    <div>{!! $question->description !!}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg border my-2.5 p-6 text-center text-gray-500">
                    আপনার ফিল্টার অনুযায়ী কোনো প্রশ্ন পাওয়া যায়নি।
                </div>
            @endforelse
        </div>
    </div>

    <!-- ================= ডাইনামিক এডভান্সড ফিল্টার সাইডবার ================= -->
    <div>
        <div class="hidden bg-white fixed top-0 right-0 z-[1000] overflow-y-auto lg:z-0 py-5 lg:py-0 lg:sticky lg:block lg:top-16 w-80 print:hidden h-screen overflow-y-scroll sidebar">
            <div class="px-3 lg:px-1 bangla">
                <div class="border rounded-t text-lg font-bold py-2 text-center">এডভান্সড ফিল্টার</div>

                <!-- মূল সার্চ বার -->
                <div class="my-2.5">
                    <input type="text" wire:model.live.debounce.300ms="searchKeyword" placeholder="প্রশ্নের ভেতর কিওয়ার্ড সার্চ..." class="bangla w-full rounded-md border-gray-300 border p-1.5 text-sm focus:ring-2 focus:ring-green-500">
                </div>

                <!-- ক্লাস, সাবজেক্ট, চ্যাপ্টার ড্রপডাউন -->
                <div class="my-4 rounded-lg border">
                    <div class="font-bold p-2 bg-gray-100 rounded-t-lg">শ্রেণি ও বিষয় নির্বাচন</div>
                    <div class="p-2 space-y-2">
                        <select wire:model.live="selectedClassId" class="w-full border rounded p-1.5 text-sm">
                            <option value="">-- শ্রেণি বাছাই করুন --</option>
                            @foreach($availableClasses as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="selectedSubjectId" class="w-full border rounded p-1.5 text-sm">
                            <option value="">-- বিষয় বাছাই করুন --</option>
                            @foreach($availableSubjects as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>

                        <select wire:model.live="selectedChapterId" class="w-full border rounded p-1.5 text-sm">
                            <option value="">-- অধ্যায় বাছাই করুন --</option>
                            @foreach($availableChapters as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- এক্সাম ক্যাটাগরি (সমাধান করা ভার্সন) -->
                @if(count($availableExamCategories) > 0)
                    <div class="my-4 rounded-lg border border-purple-300 bg-purple-50"
                         x-data="{ searchExam: '' }">
                        <div class="font-bold p-2 rounded-t-lg text-purple-900">পরীক্ষার ধরন</div>
                        <div class="px-2 pt-2 pb-1">
                            <input type="text" x-model="searchExam" placeholder="🔍 পরীক্ষা সার্চ করুন..." class="w-full border border-purple-300 rounded p-1.5 text-sm bg-white focus:ring-1 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div class="p-2 pt-1 space-y-1 max-h-40 overflow-y-auto">
                            @foreach($availableExamCategories as $id => $name)
                                <label class="px-2 py-0.5 flex items-center cursor-pointer rounded transition-colors {{ in_array($id, $activeExamCategoryIds) ? 'bg-purple-100 font-bold text-purple-800 border border-purple-400' : 'hover:bg-purple-50 text-gray-700' }}"
                                       x-show="{{ Js::from($name) }}.toLowerCase().includes(searchExam.toLowerCase())"
                                       x-cloak>
                                    <input wire:model.live="selectedExamCategories" value="{{ $id }}" type="checkbox" class="mr-2 rounded text-purple-600">
                                    <span class="w-full text-sm">{{ $name }}</span>
                                    @if(in_array($id, $activeExamCategoryIds))
                                        <span class="text-[10px] bg-purple-500 text-white px-1.5 rounded-full ml-1 shrink-0">✓</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ডিফিকাল্টি -->
                <div class="my-4 rounded-lg border">
                    <div class="font-bold p-2 bg-gray-100 rounded-t-lg">ডিফিকাল্টি লেভেল</div>
                    <div class="p-2 space-y-1">
                        @foreach(['easy' => 'সহজ', 'medium' => 'মাধ্যম', 'hard' => 'কঠিন'] as $key => $label)
                            <label class="px-2 py-0.5 flex items-center cursor-pointer rounded hover:bg-slate-100">
                                <input wire:model.live="selectedDifficulties" value="{{ $key }}" type="checkbox" class="mr-2 rounded">
                                <span class="w-full">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- প্রশ্নের ধরন -->
                <div class="my-4 rounded-lg border">
                    <div class="font-bold p-2 bg-gray-100 rounded-t-lg">প্রশ্নের ধরন</div>
                    <div class="p-2 space-y-1">
                        @foreach(['mcq' => 'MCQ', 'cq' => 'CQ (সৃজনশীল)', 'short' => 'Short Question', 'written' => 'Written'] as $key => $label)
                            <label class="px-2 py-0.5 flex items-center cursor-pointer rounded hover:bg-slate-100">
                                <input wire:model.live="selectedTypes" value="{{ $key }}" type="checkbox" class="mr-2 rounded">
                                <span class="w-full uppercase text-sm">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- টপিক -->
                @if(count($availableTopics) > 0)
                    <div class="my-4 rounded-lg border">
                        <div class="font-bold p-2 bg-gray-100 rounded-t-lg">টপিক</div>
                        <div class="p-2 space-y-1 max-h-48 overflow-y-auto">
                            @foreach($availableTopics as $topicId => $topicName)
                                <label class="px-2 py-0.5 flex items-center cursor-pointer rounded hover:bg-slate-100">
                                    <input wire:model.live="selectedTopics" value="{{ $topicId }}" type="checkbox" class="mr-2 rounded">
                                    <span class="w-full truncate text-sm" title="{{ $topicName }}">{{ $topicName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- ট্যাগসমূহ (সমাধান করা ভার্সন) -->
                @if(count($availableTags) > 0)
                    <div class="my-4 rounded-lg border border-green-400 bg-gradient-to-r from-green-50 to-white"
                         x-data="{ searchTag: '' }">
                        <div class="font-bold p-2 text-green-800">ট্যাগসমূহ</div>
                        <div class="px-2 pt-2 pb-1">
                            <input type="text" x-model="searchTag" placeholder="🔍 ট্যাগ সার্চ করুন..." class="w-full border border-green-300 rounded p-1.5 text-sm bg-white focus:ring-1 focus:ring-green-500 focus:border-green-500">
                        </div>
                        <div class="p-2 pt-1 space-y-1 max-h-60 overflow-y-auto">
                            @foreach($availableTags as $id => $name)
                                <label class="px-2 py-0.5 flex items-center cursor-pointer rounded transition-colors {{ in_array($id, $activeTagIds) ? 'bg-green-100 font-bold text-green-800 border border-green-400' : 'hover:bg-slate-100 text-gray-700' }}"
                                       x-show="{{ Js::from($name) }}.toLowerCase().includes(searchTag.toLowerCase())"
                                       x-cloak>
                                    <input wire:model.live="selectedTags" value="{{ $id }}" type="checkbox" class="mr-2 rounded">
                                    <span class="w-full truncate text-sm">{{ $name }}</span>
                                    @if(in_array($id, $activeTagIds))
                                        <span class="text-[10px] bg-green-600 text-white px-1.5 rounded-full ml-1 shrink-0">✓</span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
            <div class="h-52"></div>
        </div>
    </div>

    <!-- সার্চ করার সময় ডেটা লোড হওয়ার আগে ঝাপসা না দেখানোর জন্য -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>

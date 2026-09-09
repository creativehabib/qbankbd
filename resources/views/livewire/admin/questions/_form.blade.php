<div x-data="{ questionType: @entangle('question_type') }" class="w-full !max-w-full mx-auto">

    {{-- Header Section --}}
    <div class="mb-8 p-6 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-950 dark:text-white tracking-tight">{{ $formTitle }}</h2>
            <p class="text-base text-gray-600 dark:text-gray-400 mt-1.5">{{ $formDescription }}</p>
        </div>

        {{-- Back Button --}}
        <div class="shrink-0 self-start sm:self-auto">
            <a href="{{ route('questions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow transition-all duration-200">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="size-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg">
                    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="48" d="M244 400L100 256l144-144M120 256h292"></path>
                </svg>
                Back to Questions
            </a>
        </div>
    </div>

    <form wire:submit.prevent="save" class="flex flex-col lg:flex-row gap-8 items-start">

        {{-- Left Column (Main Area) --}}
        <div class="flex-1 space-y-8 w-full">

            {{-- AI Assistant Section --}}
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-6 rounded-2xl border border-indigo-100 dark:border-indigo-900 shadow-sm transition hover:shadow-md">
                <h3 class="text-base font-bold text-indigo-800 dark:text-indigo-400 uppercase tracking-wider mb-4 flex items-center gap-2.5">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900 rounded-lg text-indigo-600 dark:text-indigo-300">
                        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path></svg>
                    </div>
                    AI Auto-Fill Assistant
                </h3>

                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 w-full relative">
                        <input type="text" wire:model="aiPrompt" placeholder="কী নিয়ে প্রশ্ন বানাতে চান? (যেমন: বাংলাদেশের স্বাধীনতা যুদ্ধ)" class="w-full px-4 py-3 rounded-xl border border-indigo-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-indigo-800 dark:text-white dark:placeholder-gray-500 h-[50px] text-base transition">
                    </div>

                    <button type="button" wire:click="generateAiQuestion" wire:loading.attr="disabled" class="w-full md:w-auto px-7 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2.5 shrink-0 h-[50px] text-base">
                        <span wire:loading.remove wire:target="generateAiQuestion" class="flex items-center gap-2">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M13 3C13 2.44772 12.5523 2 12 2C11.4477 2 11 2.44772 11 3V11H3C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H11V21C11 21.5523 11.4477 22 12 22C12.5523 22 13 21.5523 13 21V13H21C21.5523 13 22 12.5523 22 12C22 11.4477 21.5523 11 21 11H13V3Z"></path></svg>
                            Generate MCQ
                        </span>
                        <span wire:loading.flex wire:target="generateAiQuestion" class="items-center justify-center gap-2.5">
                            <svg class="animate-spin size-5 text-white shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                            <span>Thinking...</span>
                        </span>
                    </button>
                </div>

                <div class="flex flex-col mt-3">
                    @error('aiPrompt')<span class="text-sm text-red-600 font-semibold bg-red-50 dark:bg-red-950 px-3 py-1 rounded-md">{{ $message }}</span>@enderror
                    @if(session()->has('ai_success'))
                        <span class="text-sm text-green-700 dark:text-green-400 font-semibold bg-green-50 dark:bg-green-950 px-3 py-1 rounded-md">{{ session('ai_success') }}</span>
                    @endif
                </div>

                <p class="text-sm text-indigo-600 dark:text-indigo-400 mt-3 font-medium bg-white dark:bg-indigo-950/50 p-3 rounded-lg border border-indigo-100 dark:border-indigo-800">AI আপনার দেওয়া টপিক অনুযায়ী একটি প্রশ্ন ও ৪টি অপশন তৈরি করে নিচের ফর্মগুলো স্বয়ংক্রিয়ভাবে পূরণ করে দেবে।</p>
            </div>

            {{-- Main Form Card --}}
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-8">

                {{-- Question Title --}}
                <section>
                    <label class="block text-lg font-bold text-gray-900 dark:text-gray-100 mb-3 flex items-center gap-2">
                        <svg class="size-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22ZM12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20ZM11 15H13V17H11V15ZM13 13.3551V14H11V12.5C11 11.9477 11.4477 11.5 11.5 11.5C12.8807 11.5 14 10.3807 14 9C14 7.61929 12.8807 6.5 11.5 6.5C10.1193 6.5 9 7.61929 9 9H7C7 6.79086 8.79086 5 11 5C13.2091 5 15 6.79086 15 9C15 10.9920 13.55 12.6516 11.6601 12.9723C11.2801 13.0373 11 13.3101 11 13.6701V14H13V13.3551Z"></path></svg>
                        Main Question / Stimulus (উদ্দীপক) <span class="text-red-500">*</span>
                    </label>
                    <div wire:ignore class="ck-editor-container">
                        <textarea id="editor">{!! $title !!}</textarea>
                    </div>
                    @error('title')<span class="text-sm text-red-600 mt-2 block font-medium">{{ $message }}</span>@enderror
                </section>

                {{-- Attachment Section --}}
                <section x-show="['written', 'short'].includes(questionType)" style="display: none;" x-transition class="pt-6 border-t dark:border-gray-800">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2.5">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-md text-gray-600 dark:text-gray-400">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M432 112V96a48.14 48.14 0 0 0-48-48H64a48.14 48.14 0 0 0-48 48v256a48.14 48.14 0 0 0 48 48h16v16a48.14 48.14 0 0 0 48 48h320a48.14 48.14 0 0 0 48-48V160a48.14 48.14 0 0 0-48-48zM96 128h272.24l-37.81-48.4a15.89 15.89 0 0 0-25-.63L234.62 170.81l-40.42-37.2a15.87 15.87 0 0 0-22.18 1.14l-81.82 93V96a16 16 0 0 1 16-16h320a16 16 0 0 1 16 16v224H128a48.06 48.06 0 0 0-32 12.31V144a16 16 0 0 1 0-16zM464 416a16 16 0 0 1-16 16H128a16 16 0 0 1-16-16V160a16 16 0 0 1 16-16h320a16 16 0 0 1 16 16z"></path><circle cx="336" cy="192" r="32"></circle></svg>
                        </div>
                        Reference Image / Attachment <span class="text-xs font-normal text-gray-500 bg-gray-100 dark:bg-gray-800 px-2.5 py-1 rounded-full ml-1">Optional</span>
                    </label>
                    <div class="flex justify-center px-6 pt-6 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-2xl hover:border-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30">
                        <div class="space-y-2 text-center w-full">
                            @if ($image)
                                <div class="relative w-max mx-auto mb-4 group p-1 bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                                    <img src="{{ $image->temporaryUrl() }}" class="mx-auto h-48 object-contain rounded-lg">
                                    <button type="button" wire:click="$set('image', null)" class="absolute -top-3 -right-3 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-lg transition opacity-100 sm:opacity-0 group-hover:opacity-100">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @elseif(!empty($existingImage))
                                <div class="relative w-max mx-auto mb-4 group p-1 bg-white dark:bg-gray-800 rounded-xl shadow-md border dark:border-gray-700">
                                    <img src="{{ Storage::url($existingImage) }}" class="mx-auto h-48 object-contain rounded-lg">
                                    <button type="button" wire:click="removeExistingImage" class="absolute -top-3 -right-3 bg-red-600 hover:bg-red-700 text-white rounded-full p-1.5 shadow-lg transition opacity-100 sm:opacity-0 group-hover:opacity-100" title="Remove Image">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @else
                                <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-full inline-block mb-2">
                                    <svg class="mx-auto h-10 w-10 text-gray-500 dark:text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white dark:bg-gray-800 py-2 px-4 border border-gray-300 dark:border-gray-700 rounded-xl font-semibold text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-950 transition shadow-sm focus-within:outline-none">
                                    <span>Upload a file</span>
                                    <input id="file-upload" wire:model="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 pt-2">PNG, JPG, WEBP up to 2MB</p>

                            <div wire:loading wire:target="image" class="text-sm text-indigo-600 dark:text-indigo-400 font-bold mt-3 animate-pulse flex items-center justify-center gap-2">
                                <svg class="animate-spin size-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
                                Uploading image...
                            </div>
                        </div>
                    </div>
                </section>

                {{-- MCQ Options Section --}}
                <section x-show="questionType === 'mcq'" x-transition class="pt-8 border-t dark:border-gray-800">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                        <label class="text-xl font-extrabold text-blue-800 dark:text-blue-400 flex items-center gap-2.5 tracking-tight">
                            <div class="p-2 bg-blue-100 dark:bg-blue-950 rounded-lg">
                                <svg class="size-6" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm115.9 177.9L218 339.8c-7.4 7.4-19.4 7.4-26.9 0l-83-83c-7.4-7.4-7.4-19.4 0-26.9l22.6-22.6c7.4-7.4 19.4-7.4 26.9 0l47 47 131-131c7.4-7.4 19.4-7.4 26.9 0l22.6 22.6c7.4 7.5 7.4 19.5 0 26.9z"></path></svg>
                            </div>
                            MCQ Options (বহুনির্বাচনী অপশন)
                        </label>
                        <button type="button" wire:click="addOption" class="flex items-center justify-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-5 py-2.5 rounded-xl shadow hover:shadow-lg text-sm font-bold transition-all">
                            <svg class="size-4" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg Add Option
                        </button>
                    </div>

                    <div class="space-y-6 bg-gray-50 dark:bg-gray-800/50 p-5 md:p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-inner">
                        @php $mcqLabels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ', 'ছ']; @endphp

                        @foreach($options as $i => $opt)
                            <div wire:key="opt-{{ $i }}" class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative duration-200 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-800 group">

                                <button type="button" wire:click="removeOption({{ $i }})" class="absolute -top-3 -right-3 bg-red-100 dark:bg-red-950 hover:bg-red-600 text-red-600 dark:text-red-400 hover:text-white rounded-full p-2 shadow-md transition opacity-100 sm:opacity-0 group-hover:opacity-100 z-10">
                                    <svg class="size-4" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 352 512" xmlns="http://www.w3.org/2000/svg"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                                </button>

                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4 pr-0 sm:pr-6">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Option:</span>
                                        <div class="size-9 flex items-center justify-center font-bold text-xl bg-blue-100 dark:bg-blue-900/50 text-blue-900 dark:text-blue-200 rounded-lg border border-blue-200 dark:border-blue-800">
                                            {{ $mcqLabels[$i] ?? ($i+1) }}
                                        </div>
                                    </div>

                                    <label class="flex items-center gap-2 sm:ml-auto cursor-pointer bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl transition hover:bg-green-50 dark:hover:bg-green-950 has-[:checked]:border-green-400">
                                        <input type="checkbox" wire:model="options.{{ $i }}.is_correct" class="rounded text-green-600 h-5 w-5 border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-green-400" @if(!empty($opt['is_correct']) && $opt['is_correct']) checked @endif>
                                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">Correct Answer</span>
                                    </label>
                                </div>

                                <div wire:ignore class="ck-editor-container options-editor">
                                    <textarea id="opt_editor_{{ $i }}">{!! $opt['option_text'] ?? '' !!}</textarea>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('options.*.option_text')<span class="text-sm text-red-600 font-bold block mt-3 text-center bg-red-50 dark:bg-red-950 p-3 rounded-lg border border-red-100 dark:border-red-900">* সবগুলো অপশন পূরণ করা আবশ্যক।</span>@enderror
                </section>

                {{-- CQ Section --}}
                <section x-show="questionType === 'cq'" style="display: none;" x-transition class="pt-8 border-t dark:border-gray-800">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                        <label class="text-xl font-extrabold text-purple-800 dark:text-purple-400 flex items-center gap-2.5 tracking-tight">
                            <div class="p-2 bg-purple-100 dark:bg-purple-950 rounded-lg">
                                <svg class="size-6" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
                            </div>
                            Creative Questions (সৃজনশীল অংশ)
                        </label>
                        <button type="button" wire:click="addCqPart" class="flex items-center justify-center gap-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-xl shadow hover:shadow-lg text-sm font-bold transition-all">
                            <svg class="size-4" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path></svg> Add Part
                        </button>
                    </div>

                    <div class="space-y-6 bg-gray-50 dark:bg-gray-800/50 p-5 md:p-6 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-inner">
                        @foreach($cq as $index => $part)
                            <div wire:key="cq-part-{{ $part['id'] ?? $index }}" class="bg-white dark:bg-gray-900 p-5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm relative transition-all duration-200 hover:shadow-md hover:border-purple-300 dark:hover:border-purple-800 group">

                                <button type="button" wire:click="removeCqPart({{ $index }})" class="absolute -top-3 -right-3 bg-red-100 dark:bg-red-950 hover:bg-red-600 text-red-600 dark:text-red-400 hover:text-white rounded-full p-2 shadow-md transition opacity-100 sm:opacity-0 group-hover:opacity-100 z-10">
                                    <svg class="size-4" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 352 512" xmlns="http://www.w3.org/2000/svg"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg>
                                </button>

                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                                    <div class="flex items-center gap-2.5">
                                        <span class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Label:</span>
                                        <input type="text" wire:model.live="cq.{{ $index }}.label" class="w-16 font-extrabold text-center bg-purple-100 dark:bg-purple-900/50 text-purple-950 dark:text-purple-200 rounded-lg border border-purple-200 dark:border-purple-800 focus:ring-2 focus:ring-purple-400 py-2 text-lg" placeholder="ক">
                                    </div>
                                    <div class="flex items-center gap-2.5 sm:ml-auto bg-gray-50 dark:bg-gray-800 px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700">
                                        <span class="text-sm font-bold text-gray-600 dark:text-gray-300">Marks:</span>
                                        <input type="number" wire:model.live="cq.{{ $index }}.marks" class="w-20 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-center font-bold focus:ring-purple-400 py-1.5" min="0" step="0.5">
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <span class="text-sm font-bold text-gray-600 dark:text-gray-300 uppercase block mb-2 tracking-wide">Question (প্রশ্ন)</span>
                                    <div wire:ignore class="ck-editor-container cq-editor">
                                        <textarea id="cq_editor_{{ $part['id'] ?? $index }}" class="cq-dynamic-editor" data-index="{{ $index }}">{!! $part['text'] ?? '' !!}</textarea>
                                    </div>
                                </div>

                                <div x-data="{
                                        showAnswer: {{ !empty($part['answer']) ? 'true' : 'false' }},
                                        initAnsEditor() {
                                            if (typeof CKEDITOR !== 'undefined' && !CKEDITOR.instances['cq_answer_{{ $part['id'] ?? $index }}']) {
                                                initCkEditor4('cq_answer_{{ $part['id'] ?? $index }}', 'cq.{{ $index }}.answer', true);
                                            }
                                        }
                                     }"
                                     x-init="
                                        if(showAnswer) setTimeout(() => initAnsEditor(), 100);
                                        window.addEventListener('refresh-editors', () => {
                                            if(showAnswer) setTimeout(() => initAnsEditor(), 350);
                                        });
                                     "
                                     class="mt-3 border-t border-gray-100 dark:border-gray-800 pt-3">

                                    <button type="button"
                                            @click="showAnswer = !showAnswer; if(showAnswer) setTimeout(() => initAnsEditor(), 50);"
                                            class="text-sm font-bold text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 flex items-center gap-2 focus:outline-none transition-colors w-full text-left bg-emerald-50 dark:bg-emerald-950/50 p-3 rounded-lg border border-emerald-100 dark:border-emerald-900">
                                        <svg class="size-5 transition-transform duration-300" :class="showAnswer ? 'rotate-180' : ''" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 294.1L383 167c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-144 144c-9.4 9.4-24.6 9.4-33.9 0l-144-144c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0L256 294.1z"></path></svg>
                                        <span x-text="showAnswer ? 'Hide Answer (উত্তর লুকান)' : 'Add Answer / Solution (উত্তর যুক্ত করুন - ঐচ্ছিক)'"></span>
                                    </button>

                                    <div x-show="showAnswer" x-transition class="mt-4" style="display: none;">
                                        <div wire:ignore class="ck-editor-container answer-editor">
                                            <textarea id="cq_answer_{{ $part['id'] ?? $index }}">{!! $part['answer'] ?? '' !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                {{-- General Solution --}}
                <section class="pt-8 border-t dark:border-gray-800">
                    <label class="block text-base font-bold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                        <div class="p-1.5 bg-green-100 dark:bg-green-950 rounded-md text-green-700 dark:text-green-400">
                            <svg class="size-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>
                        </div>
                        General Solution / Description <span class="text-xs font-normal text-gray-500 bg-gray-100 dark:bg-gray-800 px-2.5 py-1 rounded-full ml-1">Optional</span>
                    </label>
                    <div wire:ignore class="ck-editor-container description-editor">
                        <textarea id="description_editor">{!! $description !!}</textarea>
                    </div>
                </section>

                {{-- Slug Input --}}
                <div class="pt-6 border-t dark:border-gray-800">
                    <x-slug-input table="questions" :ignore-id="$question->id ?? null" class="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-xl border dark:border-gray-700"/>
                </div>
            </div>

        </div>

        {{-- Right Column (Sidebar) --}}
        <div class="w-full lg:w-[360px] xl:w-[420px] space-y-8 shrink-0 lg:sticky lg:top-24">

            {{-- Categorization Card --}}
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-7 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-6">
                <h3 class="text-sm font-bold text-gray-950 dark:text-white uppercase tracking-wider flex items-center gap-2.5 pb-3 border-b dark:border-gray-800">
                    <div class="p-1.5 bg-indigo-100 dark:bg-indigo-950 rounded-md text-indigo-600 dark:text-indigo-400">
                        <svg class="size-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M496 128v16a8 8 0 0 1-8 8h-24v12c0 6.627-5.373 12-12 12H60c-6.627 0-12-5.373-12-12v-12H24a8 8 0 0 1-8-8v-16a8 8 0 0 1 8-8h22.758c5.441-26.657 20.301-49.851 40.718-67.653C104.992 40.404 115.309 32 128 32h256c12.691 0 23.008 8.404 40.524 20.347C444.941 70.149 459.801 93.343 465.242 120H488a8 8 0 0 1 8 8zM176 80c-8.837 0-16 7.163-16 16v16h256v-16c0-8.837-7.163-16-16-16H176zm-56 304h272v108c0 6.627-5.373 12-12 12H132c-6.627 0-12-5.373-12-12V384zm316-208H76c-6.627 0-12 5.373-12 12v152c0 6.627 5.373 12 12 12h360c6.627 0 12-5.373 12-12V188c0-6.627-5.373-12-12-12z"></path></svg>
                    </div>
                    Categorization
                </h3>

                <div class="space-y-5">
                    <div wire:ignore wire:key="class-select-{{ $question->id ?? 'create' }}">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Class <span class="text-red-500">*</span></label>
                        <select id="academic_class" class="w-full">
                            <option value="">-- Select Class --</option>
                            @foreach($classes as $class) <option value="{{ $class->id }}" @selected($class->id == $academic_class_id)>{{ $class->name }}</option> @endforeach
                        </select>
                        @error('academic_class_id')<span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>@enderror
                    </div>

                    <div wire:ignore wire:key="subject-select-{{ $question->id ?? 'create' }}">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Subject <span class="text-red-500">*</span></label>
                        <select id="subject" class="w-full">
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $s) <option value="{{ $s->id }}" @selected($s->id == $subject_id)>{{ $s->name }}</option> @endforeach
                        </select>
                        @error('subject_id')<span class="text-xs text-red-500 mt-1 block font-medium">{{ $message }}</span>@enderror
                    </div>

                    <div wire:ignore wire:key="subsubject-select-{{ $question->id ?? 'create' }}">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Chapter / Paper</label>
                        <select id="chapter" class="w-full">
                            <option value="">-- Select Chapter --</option>
                            @foreach($chapters as $ss) <option value="{{ $ss->id }}" @selected($ss->id == $chapter_id)>{{ $ss->name }}</option> @endforeach
                        </select>
                    </div>

                    <div wire:ignore wire:key="topic-select-{{ $question->id ?? 'create' }}">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Topic</label>
                        <select id="topic" class="w-full">
                            <option value="">-- Select Topic --</option>
                            @foreach($topics as $c) <option value="{{ $c->id }}" @selected($c->id == $topic_id)>{{ $c->name }}</option> @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Question Settings Card --}}
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-7 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-6">
                <h3 class="text-sm font-bold text-gray-950 dark:text-white uppercase tracking-wider flex items-center gap-2.5 pb-3 border-b dark:border-gray-800">
                    <div class="p-1.5 bg-blue-100 dark:bg-blue-950 rounded-md text-blue-600 dark:text-blue-400">
                        <svg class="size-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-85.6 72.8c1.7 8.2 2.6 16.6 2.6 25.1s-.9 16.9-2.6 25.1l85.6 72.8c6.9 6.2 9.6 15.9 6.4 24.6l-44.3 119.3c-3.2 8.7-12.2 14.3-21.2 14.3H320c-13.3 0-24-10.7-24-24V408c0-13.3-10.7-24-24-24H240c-13.3 0-24 10.7-24 24v96c0 13.3-10.7 24-24 24H83.6c-9 0-18-5.6-21.2-14.3L18.1 394.7c-3.2-8.7-.5-18.4 6.4-24.6l85.6-72.8C108.4 311.9 107.5 303.5 107.5 295s.9-16.9 2.6-25.1L24.5 197.1c-6.9-6.2-9.6-15.9-6.4-24.6L62.4 53.2C65.6 44.5 74.6 38.9 83.6 38.9H200c13.3 0 24 10.7 24 24v96c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24V62.9c0-13.3 10.7-24 24-24H428.4c9 0 18 5.6 21.2 14.3l44.3 119.3zM160 256a96 96 0 1 0 192 0 96 96 0 1 0 -192 0z"></path></svg>
                    </div>
                    Question Settings
                </h3>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Difficulty Level</label>
                        <select wire:model="difficulty" class="block w-full px-3 py-2.5 text-base rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-gray-200">
                            <option value="easy">Easy 😊</option>
                            <option value="medium">Medium 😐</option>
                            <option value="hard">Hard 🤯</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Question Type</label>
                        <select wire:model.live="question_type" class="block w-full px-3 py-2.5 text-base rounded-xl border border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:text-gray-200 font-medium">
                            <option value="mcq">Multiple Choice (MCQ)</option>
                            <option value="cq">Creative Question (CQ)</option>
                            <option value="short">Short Question</option>
                            <option value="written">Written Question (লিখিত)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Total Marks</label>
                        <div class="relative rounded-xl shadow-sm">
                            <input type="number" step="0.5" min="0" wire:model.live="marks"
                                   x-bind:readonly="questionType === 'cq'"
                                   x-bind:class="questionType === 'cq' ? 'bg-gray-100 dark:bg-gray-800 text-gray-500 cursor-not-allowed' : 'bg-white dark:bg-gray-900'"
                                   class="block w-full px-4 py-2.5 text-base rounded-xl border border-gray-300 dark:border-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:text-gray-200 pr-16 font-bold" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-500 dark:text-gray-500 sm:text-sm font-medium">Marks</span>
                            </div>
                        </div>
                        <span x-show="questionType === 'cq'" style="display: none;" class="text-xs text-purple-700 dark:text-purple-400 font-semibold mt-2 flex items-center gap-1.5 bg-purple-50 dark:bg-purple-950 p-2 rounded-lg border border-purple-100 dark:border-purple-900"><svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg> Auto calculated from CQ parts</span>
                    </div>
                </div>
            </div>

            {{-- Metadata Card --}}
            <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-indigo-950/30 dark:via-gray-900 dark:to-purple-950/30 p-7 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-6">
                <h3 class="text-sm font-bold text-gray-950 dark:text-white uppercase tracking-wider flex items-center gap-2.5 pb-3 border-b dark:border-gray-800">
                    <div class="p-1.5 bg-green-100 dark:bg-green-950 rounded-md text-green-700 dark:text-green-400">
                        <svg class="size-5" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
                    </div>
                    Tags & Exam Categories
                </h3>

                <div class="space-y-5">
                    <div wire:ignore>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Tags <span class="text-gray-400 dark:text-gray-500 font-normal">(Type and press enter)</span></label>
                        <select id="tags" class="w-full" multiple>
                            @foreach($allTags as $tag) <option value="{{ $tag->id }}" {{ in_array($tag->id, $tagIds) ? 'selected' : '' }}>{{ $tag->name }}</option> @endforeach
                        </select>
                    </div>

                    <div wire:ignore>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">Exam Category <span class="text-red-500">*</span></label>
                        <select id="exam_categories" class="w-full" multiple placeholder="Select Exam (BCS, HSC...)">
                            @foreach($allExamCategories as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, $exam_category_ids) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_category_ids')<span class="text-xs text-red-500 mt-1.5 block font-medium bg-red-50 dark:bg-red-950 p-2 rounded-lg border border-red-100 dark:border-red-900">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="pt-4 lg:pt-0">
                <button type="submit" class="w-full px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xl font-extrabold rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 tracking-tight">
                    <svg class="size-6" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z"></path></svg>
                    {{ $buttonText }}
                </button>
            </div>

        </div>
    </form>
</div>

@push('scripts')
    <!-- TomSelect CSS & JS (Required to fix dropdown issues) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    <!-- CKEditor 4 -->
    <script src="https://cdn.ckeditor.com/4.22.1/full-all/ckeditor.js"></script>

    <script>
        window.tsClass = window.tsClass || null;
        window.tsSubject = window.tsSubject || null;
        window.tsChapter = window.tsChapter || null;
        window.tsTopic = window.tsTopic || null;
        window.tsTags = window.tsTags || null;
        window.tsExamCategories = window.tsExamCategories || null;

        function generateSlug(text) {
            let div = document.createElement("div");
            div.innerHTML = text;
            let plainText = div.innerText || div.textContent || "";
            return plainText.trim().toLowerCase().replace(/[^\w\u0980-\u09FF\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '').substring(0, 100);
        }

        function initCkEditor4(elementId, livewireProperty, isAdvanced = false) {
            const el = document.getElementById(elementId);
            if (!el || el.offsetParent === null) return;

            if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[elementId]) {
                try { CKEDITOR.instances[elementId].destroy(true); } catch(e) {}
            }

            let toolbarConfig = [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Subscript', 'Superscript'] },
                { name: 'insert', items: ['SpecialCharacter', 'Mathjax'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'document', items: ['Source'] }
            ];

            if (isAdvanced) {
                toolbarConfig = [
                    { name: 'clipboard', items: ['Undo', 'Redo'] },
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                    { name: 'links', items: ['Link', 'Unlink'] },
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialCharacter', 'Mathjax'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize'] },
                    { name: 'document', items: ['Source'] }
                ];
            }

            const editor = CKEDITOR.replace(elementId, {
                extraPlugins: 'mathjax,tableresize,wordcount,notification,justify,font,colorbutton',
                mathJaxLib: '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
                toolbar: toolbarConfig,
                height: isAdvanced ? 180 : 120,
                allowedContent: true,
                uiColor: document.documentElement.classList.contains('dark') ? '#2d3748' : '#f9fafb'
            });

            let ckDebounceTimer;
            editor.on('change', function () {
                let data = editor.getData();
                clearTimeout(ckDebounceTimer);
                ckDebounceTimer = setTimeout(() => {
                @this.set(livewireProperty, data);
                    if (livewireProperty === 'title') {
                        let isEditMode = window.location.href.includes('/edit');
                        let slugInput = document.getElementById('slug_input');
                        if (slugInput) {
                            let isManualEdited = slugInput.getAttribute('data-manual') === 'true';
                            if (!isEditMode && !isManualEdited) {
                                let newSlug = generateSlug(data);
                                window.dispatchEvent(new CustomEvent('slug-auto-updated', { detail: newSlug }));
                            }
                        }
                    }
                }, 500);
            });
        }

        function initEditors() {
            // Initialize CKEditors
            initCkEditor4('editor', 'title');
            initCkEditor4('description_editor', 'description', true);

            document.querySelectorAll('textarea[id^="opt_editor_"]').forEach(el => {
                let idx = el.id.replace('opt_editor_', '');
                initCkEditor4(el.id, `options.${idx}.option_text`);
            });

            document.querySelectorAll('textarea.cq-dynamic-editor').forEach(el => {
                let dIndex = el.getAttribute('data-index');
                initCkEditor4(el.id, `cq.${dIndex}.text`);
            });

            // Initialize TomSelect
            if (typeof TomSelect !== 'undefined') {

                const tsConfig = {
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
                    plugins: ['remove_button', 'dropdown_input'],
                    persist: false,
                    create: true,
                };

                const updateLivewire = (property, value) => {
                    if (typeof $wire !== 'undefined') {
                        $wire.set(property, value);
                    } else if (typeof @this !== 'undefined') {
                    @this.set(property, value);
                    }
                };

                const classEl = document.getElementById('academic_class');
                if (classEl && !classEl.tomselect) window.tsClass = new TomSelect(classEl, {...tsConfig, onChange: (v) => updateLivewire('academic_class_id', v) });

                const subjectEl = document.getElementById('subject');
                if (subjectEl && !subjectEl.tomselect) window.tsSubject = new TomSelect(subjectEl, {...tsConfig, onChange: (v) => updateLivewire('subject_id', v) });

                const chapterEl = document.getElementById('chapter');
                if (chapterEl && !chapterEl.tomselect) window.tsChapter = new TomSelect(chapterEl, {...tsConfig, onChange: (v) => updateLivewire('chapter_id', v) });

                const topicEl = document.getElementById('topic');
                if (topicEl && !topicEl.tomselect) window.tsTopic = new TomSelect(topicEl, {...tsConfig, onChange: (v) => updateLivewire('topic_id', v) });

                const tagsEl = document.getElementById('tags');
                if (tagsEl && !tagsEl.tomselect) window.tsTags = new TomSelect(tagsEl, {...tsMultiConfig, onChange: (v) => updateLivewire('tagIds', v) });

                const examCategoriesEl = document.getElementById('exam_categories');
                if (examCategoriesEl && !examCategoriesEl.tomselect) window.tsExamCategories = new TomSelect(examCategoriesEl, { ...tsMultiConfig, create: false, onChange: (v) => updateLivewire('exam_category_ids', v) });
            } else {
                console.error("TomSelect is not loaded!");
            }
        }

        if (!window.hasRegisteredQuestionEvents) {
            window.addEventListener('subjectsUpdated', e => {
                if (window.tsSubject) {
                    window.tsSubject.clear(true);
                    window.tsSubject.clearOptions();
                    window.tsSubject.addOption({value: '', text: '-- Select Subject --'});
                    window.tsSubject.addOptions(e.detail.subjects);
                    window.tsSubject.refreshOptions(false);
                }
            });

            window.addEventListener('chaptersUpdated', e => {
                if (window.tsChapter) {
                    window.tsChapter.clear(true);
                    window.tsChapter.clearOptions();
                    window.tsChapter.addOption({value: '', text: '-- Select Chapter --'});
                    window.tsChapter.addOptions(e.detail.chapters);
                    window.tsChapter.refreshOptions(false);
                }
            });

            window.addEventListener('topicsUpdated', e => {
                if (window.tsTopic) {
                    window.tsTopic.clear(true);
                    window.tsTopic.clearOptions();
                    window.tsTopic.addOption({value: '', text: '-- Select Topic --'});
                    window.tsTopic.addOptions(e.detail.topics);
                    window.tsTopic.refreshOptions(false);
                }
            });

            window.addEventListener('reset-selects', () => {
                window.tsClass?.clear(true);
                window.tsSubject?.clear(true);
                window.tsChapter?.clear(true);
                window.tsTopic?.clear(true);
                window.tsExamCategories?.clear(true);
            });

            window.addEventListener('refresh-editors', () => setTimeout(initEditors, 350));

            document.addEventListener('livewire:load', () => setTimeout(initEditors, 100));
            document.addEventListener('livewire:navigated', () => setTimeout(initEditors, 100));
            document.addEventListener('livewire:update', () => setTimeout(initEditors, 350));

            document.addEventListener('livewire:navigating', () => {
                for (let instanceName in CKEDITOR.instances) {
                    try { CKEDITOR.instances[instanceName].destroy(true); } catch(e) {}
                }
                if (window.tsSubject) { window.tsSubject.destroy(); window.tsSubject = null; }
                if (window.tsClass) { window.tsClass.destroy(); window.tsClass = null; }
                if (window.tsChapter) { window.tsChapter.destroy(); window.tsChapter = null; }
                if (window.tsTopic) { window.tsTopic.destroy(); window.tsTopic = null; }
                if (window.tsTags) { window.tsTags.destroy(); window.tsTags = null; }
                if (window.tsExamCategories) { window.tsExamCategories.destroy(); window.tsExamCategories = null; }
            });

            window.hasRegisteredQuestionEvents = true;
        }

        window.addEventListener('ai-data-filled', e => {
            let data = e.detail;
            if (CKEDITOR.instances['editor']) CKEDITOR.instances['editor'].setData(data.title);
            if (data.options && data.options.length > 0) {
                data.options.forEach((opt, index) => {
                    let optEditorId = 'opt_editor_' + index;
                    if (CKEDITOR.instances[optEditorId]) {
                        CKEDITOR.instances[optEditorId].setData(opt.option_text);
                    }
                });
            }
        });
    </script>
@endpush

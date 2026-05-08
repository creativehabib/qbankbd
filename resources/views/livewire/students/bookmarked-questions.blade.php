<div class="max-w-5xl mx-auto space-y-6" x-data="{ showBookmarkModal: false, selectedQuestionId: null }">

    <div class="flex items-center gap-4 rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-300">
            <flux:icon.bookmark class="size-6" variant="solid" />
        </div>
        <div>
            <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ __('আমার বুকমার্ক করা প্রশ্নসমূহ') }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">আপনার সেভ করে রাখা মোট {{ $questions->total() }} টি প্রশ্ন এখানে আছে।</p>
        </div>
    </div>

    <div>
        @if($questions->isEmpty())
            <div class="rounded-xl border border-dashed border-zinc-300 bg-white p-12 text-center text-sm text-zinc-500 shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-400">
                <flux:icon.bookmark class="mx-auto mb-3 size-12 text-zinc-300 dark:text-zinc-600" />
                <p class="text-lg font-semibold text-zinc-700 dark:text-zinc-300">{{ __('কোনো বুকমার্ক নেই') }}</p>
                <p class="mt-1">{{ __('আপনি এখনো কোনো প্রশ্ন বুকমার্ক করেননি। অনুশীলনের সময় সেভ করা প্রশ্নগুলো এখানে জমা হবে।') }}</p>
            </div>
        @else
            @php($labels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ', 'চ'])
            <div class="space-y-4">
                @foreach($questions as $question)
                    @php($options = collect($question->extra_content ?? [])->take(4))
                    @php($questionTitle = preg_replace('/^\s*<p[^>]*>(.*)<\/p>\s*$/is', '$1', html_entity_decode($question->title ?? '')) ?? html_entity_decode($question->title ?? ''))

                    <article class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
                        <h5 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100" data-math-content>{!! ($questions->firstItem() + $loop->index) . '. ' . $questionTitle !!}</h5>

                        <div class="mt-2 flex flex-wrap gap-2 text-xs">
                            <span class="rounded-full border border-zinc-300 px-2.5 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->academicClass?->name }}</span>
                            <span class="rounded-full border border-zinc-300 px-2.5 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ $question->subject?->name }}</span>
                            <span class="rounded-full border border-zinc-300 px-2.5 py-0.5 text-zinc-600 dark:border-zinc-600 dark:text-zinc-300">{{ strtoupper($question->question_type ?? 'MCQ') }}</span>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                            @foreach($options as $option)
                                <div class="flex items-center gap-3 rounded-lg border px-3 py-2.5 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-600 dark:bg-emerald-900/20' : 'border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50' }}">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border text-xs font-bold {{ !empty($option['is_correct']) ? 'border-emerald-500 bg-emerald-500 text-white' : 'border-zinc-300 text-zinc-700 dark:border-zinc-600 dark:text-zinc-200' }}">{{ $labels[$loop->index] ?? $loop->index + 1 }}</span>
                                    <span class="text-sm text-zinc-800 dark:text-zinc-100" data-math-content>{!! html_entity_decode($option['option_text'] ?? '') !!}</span>
                                </div>
                            @endforeach
                        </div>

                        <div x-data="{ openDescription: false }" class="mt-5 border-t border-zinc-200 pt-4 dark:border-zinc-700 space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                                <button type="button" x-on:click="openDescription = !openDescription" wire:click.once="recordView({{ $question->id }})" class="inline-flex w-fit items-center gap-1 text-sm font-semibold text-zinc-600 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400 transition">
                                    <span>Explanation</span>
                                    <flux:icon.chevron-down class="size-4 transition-transform" x-bind:class="openDescription ? 'rotate-180' : ''" />
                                </button>

                                <div class="flex items-center gap-4 text-zinc-500 dark:text-zinc-400">
                                    <div class="flex items-center gap-1.5" title="Views">
                                        <flux:icon.eye class="size-[18px]" />
                                        <span class="text-sm font-semibold">{{ $question->views_count ?? 0 }}</span>
                                    </div>

                                    <button
                                        type="button"
                                        onclick="confirmDeleteAction(() => @this.toggleBookmark({{ $question->id }}), {
                                            title: 'আপনি কি নিশ্চিত?',
                                            text: 'এই প্রশ্নটি আপনার বুকমার্ক লিস্ট থেকে রিমুভ হয়ে যাবে।',
                                            confirmButtonText: 'হ্যাঁ, রিমুভ করুন',
                                            confirmButtonColor: '#b03a3e'
                                        })"
                                        class="cursor-pointer transition text-emerald-600 dark:text-emerald-400 hover:text-emerald-700"
                                        title="Remove Bookmark"
                                    >
                                        <flux:icon.bookmark class="size-[18px]" variant="solid" />
                                    </button>

                                    <button type="button" wire:click="toggleLike({{ $question->id }})" class="flex items-center gap-1 cursor-pointer transition {{ $question->is_liked ? 'text-pink-500' : 'hover:text-pink-500' }}" title="{{ $question->is_liked ? 'Unlike' : 'Like' }}">
                                        @if($question->is_liked)
                                            <flux:icon.heart class="size-[18px]" variant="solid" />
                                        @else
                                            <flux:icon.heart class="size-[18px]" variant="outline" />
                                        @endif

                                        @if($question->likes_count > 0)
                                            <span class="text-xs font-medium">{{ $question->likes_count }}</span>
                                        @endif
                                    </button>
                                </div>
                            </div>

                            <div x-show="openDescription" x-collapse x-cloak class="rounded-xl border border-dashed border-zinc-300 bg-zinc-50 p-5 dark:border-zinc-700 dark:bg-zinc-800/50 mt-3">
                                @if(filled($question->description))
                                    <div class="prose prose-sm max-w-none text-zinc-700 dark:prose-invert dark:text-zinc-200" data-math-content>{!! $question->description !!}</div>
                                @else
                                    <div class="space-y-3 text-center">
                                        <flux:icon.sparkles class="mx-auto size-6 text-violet-500" />
                                        <p class="font-semibold text-zinc-600 dark:text-zinc-300">{{ __('No explanation yet') }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pt-4">
                {{ $questions->links() }}
            </div>
        @endif
    </div>
</div>

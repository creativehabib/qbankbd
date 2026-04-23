<div class="max-w-5xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100">প্রশ্ন ছবি/টেক্সট থেকে Bulk Upload</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                প্রশ্নপত্র থেকে OCR টেক্সট পেস্ট করুন। ফরম্যাট: প্রশ্ন নম্বর + (ক)(খ)(গ)(ঘ) অপশন।
            </p>
        </div>

        <form wire:submit="saveBulkQuestions" class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">শ্রেণি</label>
                    <select wire:model.live="academic_class_id" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-- Select Class --</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('academic_class_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">বিষয়</label>
                    <select wire:model.live="subject_id" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-- Select Subject --</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">অধ্যায় (ঐচ্ছিক)</label>
                    <select wire:model.live="chapter_id" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-- Select Chapter --</option>
                        @foreach($chapters as $chapter)
                            <option value="{{ $chapter->id }}">{{ $chapter->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">টপিক (ঐচ্ছিক)</label>
                    <select wire:model="topic_id" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-- Select Topic --</option>
                        @foreach($topics as $topic)
                            <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty</label>
                    <select wire:model="difficulty" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marks</label>
                    <input type="number" min="0.25" step="0.25" wire:model="marks" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                    @error('marks') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Source Image (ঐচ্ছিক)</label>
                    <input type="file" wire:model="sourceImage" accept="image/*" class="block w-full text-sm text-gray-700 dark:text-gray-200">
                    @error('sourceImage') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Target Audience</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                    @foreach($allExamCategories as $category)
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" value="{{ $category->id }}" wire:model="exam_category_ids" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('exam_category_ids') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">OCR / Raw প্রশ্ন টেক্সট</label>
                <textarea wire:model="rawText" rows="12" class="block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" placeholder="1. শব্দটির অর্থ কী? (ক) ... (খ) ... (গ) ... (ঘ) ..."></textarea>
                @error('rawText') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                    Save Bulk Questions
                </button>
                <a wire:navigate href="{{ route('questions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">Cancel</a>
            </div>
        </form>
    </div>
</div>

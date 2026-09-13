<x-layouts::app title="Teacher Dashboard">
    <div class="space-y-4 sm:space-y-5">
            <flux:card>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="space-y-1">
                        <flux:heading size="xl">{{ auth()->user()?->institution_name ?: 'অনলাইন ডিজিটাল স্কুল' }}</flux:heading>
                        <flux:subheading size="lg">{{ auth()->user()?->institution_address ?: 'Add Institution Address' }}</flux:subheading>
                    </div>

                    <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row">
                        <flux:button href="{{ route('profile.edit') }}" variant="primary">Update Profile</flux:button>
                        <flux:button href="#" variant="outline">Institution Details</flux:button>
                    </div>
                </div>
            </flux:card>

            <flux:card>
                <div class="space-y-2 text-center">
                    <flux:heading size="xl">Create Questions</flux:heading>
                    <flux:subheading>Use the E-Question Builder to create custom question papers for academic, admission, and job preparations.</flux:subheading>
                </div>

                <div
                    x-data="{ selectedClass: '', selectedSubject: '', classes: {{ Js::from(($academicClasses ?? collect())->map(fn ($class) => ['id' => (string) $class->id, 'name' => $class->name, 'subjects' => $class->subjects->map(fn ($subject) => ['id' => (string) $subject->id, 'name' => $subject->name])->values()])->values()) }}, get filteredSubjects() { if (!this.selectedClass) { return []; } const foundClass = this.classes.find((item) => item.id === this.selectedClass); return foundClass ? foundClass.subjects : []; } }"
                    class="mt-6 rounded-xl border border-dashed border-zinc-300 p-4 dark:border-zinc-700"
                >
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex flex-wrap gap-2">
                            <template x-for="academicClass in classes" :key="academicClass.id">
                                <button
                                    type="button"
                                    @click="selectedClass = academicClass.id; selectedSubject = '';"
                                    class="rounded-full border px-4 py-2 text-sm font-semibold transition-all shadow-sm"
                                    :class="selectedClass === academicClass.id ? 'border-indigo-600 bg-indigo-600 text-white shadow-indigo-200 dark:shadow-none' : 'border-zinc-200 bg-white text-zinc-600 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700'"
                                    x-text="academicClass.name"
                                ></button>
                            </template>
                        </div>

                        <div class="flex w-full flex-col gap-2 sm:flex-row lg:w-auto">
                            <select x-model="selectedSubject" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-200 sm:min-w-80">
                                <option value="">Select Subject</option>
                                <template x-for="subject in filteredSubjects" :key="subject.id">
                                    <option :value="subject.id" x-text="subject.name"></option>
                                </template>
                            </select>

                            <a
                                :href="selectedSubject ? `{{ route('question.set-create') ?? '#' }}?subject_id=${selectedSubject}` : '#'"
                                class="inline-flex items-center justify-center rounded-lg px-4 py-2 text-sm font-bold shadow-sm transition-all sm:min-w-32"
                                :class="selectedSubject ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'cursor-not-allowed bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600'"
                            >Next Step &rarr;</a>
                        </div>
                    </div>
                </div>
            </flux:card>

            <flux:card>
                <div class="space-y-1 mb-6 text-center">
                    <flux:heading size="lg">Dashboard Overview</flux:heading>
                    <flux:subheading>আপনার প্রস্তুতকৃত প্রশ্ন ও কন্ট্রিবিউশন ওভারভিউ দেখুন।</flux:subheading>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Questions</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_question_sets'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total MCQ</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_mcq_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Written</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">{{ $teacherStats['total_written_questions'] ?? 0 }}</p>
                    </div>
                    <div class="rounded-xl border border-zinc-100 bg-zinc-50/50 p-5 dark:border-zinc-700/50 dark:bg-zinc-800/50">
                        <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Cost</p>
                        <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-zinc-100">৳ {{ number_format($teacherStats['total_cost'] ?? 0, 2) }}</p>
                    </div>
                </div>
            </flux:card>

    </div>
</x-layouts::app>

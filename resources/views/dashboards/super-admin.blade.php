<x-layouts::app title="Super Admin Panel">
    <div class="space-y-6">
        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">সুপার অ্যাডমিন ড্যাশবোর্ড</h2>
            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">কে কয়টি প্রশ্ন তৈরি করেছে এবং কী ধরনের প্রশ্ন সেট তৈরি করেছে তার সারাংশ।</p>
        </section>

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-zinc-100">প্রস্তুতকারী ভিত্তিক সারাংশ</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-700">
                    <thead>
                        <tr class="text-left text-zinc-500 dark:text-zinc-400">
                            <th class="px-3 py-2">ইউজার</th>
                            <th class="px-3 py-2">মোট প্রশ্ন সেট</th>
                            <th class="px-3 py-2">মোট প্রশ্ন (quantity)</th>
                            <th class="px-3 py-2">ধরণ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse ($creatorSummary as $item)
                            <tr>
                                <td class="px-3 py-2 font-medium text-zinc-900 dark:text-zinc-100">{{ $item['user_name'] }}</td>
                                <td class="px-3 py-2">{{ $item['question_set_count'] }}</td>
                                <td class="px-3 py-2">{{ $item['question_total'] }}</td>
                                <td class="px-3 py-2 text-xs">
                                    @foreach ($item['types'] as $type => $count)
                                        <span class="mb-1 mr-1 inline-flex rounded-full bg-zinc-100 px-2 py-1 dark:bg-zinc-800">{{ strtoupper($type) }}: {{ $count }}</span>
                                    @endforeach
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-zinc-500">কোনো ডেটা পাওয়া যায়নি।</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <h3 class="mb-4 text-lg font-semibold text-zinc-900 dark:text-zinc-100">Question Sets ম্যানেজমেন্ট</h3>
            <div class="space-y-3">
                @forelse ($questionSets as $questionSet)
                    <div class="rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                        <div class="mb-2 text-sm text-zinc-500 dark:text-zinc-400">
                            তৈরি করেছেন: <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $questionSet->user?->name ?? 'Unknown' }}</span>
                            · তৈরি: {{ $questionSet->created_at?->format('d M Y, h:i A') }}
                        </div>

                        <form method="POST" action="{{ route('dashboard.question-sets.update', $questionSet) }}" class="grid gap-2 md:grid-cols-4">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="name" value="{{ $questionSet->name }}" class="rounded-lg border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-900" required>
                            <select name="type" class="rounded-lg border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-900" required>
                                @foreach (['mcq' => 'MCQ', 'cq' => 'CQ', 'short' => 'SHORT', 'written' => 'WRITTEN', 'combine' => 'COMBINE'] as $key => $label)
                                    <option value="{{ $key }}" @selected(($questionSet->generation_criteria['type'] ?? 'mcq') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                            <input type="number" min="1" max="500" name="quantity" value="{{ (int) ($questionSet->generation_criteria['quantity'] ?? 1) }}" class="rounded-lg border-zinc-300 text-sm dark:border-zinc-700 dark:bg-zinc-900" required>
                            <button type="submit" class="rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white">আপডেট</button>
                        </form>

                        <form method="POST" action="{{ route('dashboard.question-sets.destroy', $questionSet) }}" class="mt-2" onsubmit="return confirm('আপনি কি নিশ্চিত?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white">ডিলিট</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-zinc-500">কোনো Question Set নেই।</p>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts::app>

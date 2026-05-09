<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow border p-6">

        <div class="bg-gray-50 rounded p-5 border flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $token->title }}</h2>
                <div class="grid grid-cols-2 gap-x-8 gap-y-1 text-sm text-gray-600 mt-2">
                    <p>OMR কোড: <span class="font-bold text-gray-800">{{ $token->template->unique_code ?? 'N/A' }}</span></p>
                    <p>মোট প্রশ্ন: <span class="font-bold text-gray-800">{{ $token->total_questions }}</span></p>
                    <p>নেগেটিভ মার্কিং: <span class="font-bold text-red-600">{{ $token->negative_mark > 0 ? $token->negative_mark : 'নেই' }}</span></p>
                    <p>তৈরি করেছেন: <span class="font-bold text-gray-800">{{ $token->created_by }}</span></p>
                </div>
            </div>
            <div class="text-right">
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">✓ Active</span>
                <p class="text-xs text-gray-400 mt-2">ID: {{ $token->token_id }}</p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-yellow-100 text-yellow-800 rounded-md font-semibold text-center">
                {{ session('message') }}
            </div>
        @endif

        <div class="text-center mb-6">
            <h3 class="text-sm font-semibold text-gray-700">👇 আপনার প্রশ্নের উত্তরগুলো মার্ক করে নিচে 'Save' বাটনে ক্লিক করুন</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 bg-gray-50 p-6 rounded border">
            @for($q = 1; $q <= $token->total_questions; $q++)
                <div class="flex items-center justify-between border-b pb-2 border-gray-200">
                    <span class="font-bold text-gray-700 w-8">{{ $q }}.</span>
                    <div class="flex gap-2">
                        @foreach(['A' => 'ক', 'B' => 'খ', 'C' => 'গ', 'D' => 'ঘ'] as $optCode => $optLabel)
                            <button wire:click="setAnswer({{ $q }}, '{{ $optCode }}')"
                                    class="w-9 h-9 rounded-full border text-sm font-bold transition flex items-center justify-center
                                    {{ isset($answers[$q]) && $answers[$q] === $optCode
                                        ? 'bg-blue-600 text-white border-blue-600 shadow'
                                        : 'bg-white text-gray-600 border-gray-300 hover:border-gray-500' }}">
                                {{ $optLabel }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endfor
        </div>

        <div class="mt-8 flex flex-col gap-3 max-w-xs mx-auto">
            <button wire:click="saveAnswers" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2.5 rounded transition shadow">
                Save করুন
            </button>
            <button wire:click="completeSetup" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded transition shadow">
                উত্তরপত্র সম্পূর্ণ করুন
            </button>
        </div>
    </div>
</div>

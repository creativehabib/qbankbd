<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            ⚙️ Advanced OMR Evaluator 3.0
        </h2>

        @if(!$result)
            <div class="space-y-6">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50 hover:bg-gray-100 transition relative">
                    <input type="file" wire:model="omrImage" class="hidden" id="omrFile">
                    <label for="omrFile" class="cursor-pointer block">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Drag & drop OMR sheets here, or click to browse files</p>
                        @if($omrImage)
                            <p class="text-sm text-green-600 font-bold mt-2">✓ {{ $omrImage->getClientOriginalName() }} লোড হয়েছে!</p>
                        @endif
                    </label>
                </div>
                @error('omrImage') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">টোকেন নির্বাচন করুন</label>
                    <select wire:model="tokenId" class="w-full border-gray-300 rounded shadow-sm">
                        <option value="">-- পরীক্ষা টোকেন সিলেক্ট করুন --</option>
                        @foreach($tokens as $t)
                            <option value="{{ $t->token_id }}">{{ $t->title }} ({{ $t->token_id }})</option>
                        @endforeach
                    </select>
                    @error('tokenId') <span class="text-red-500 text-sm block">{{ $message }}</span> @enderror
                </div>

                <button wire:click="evaluate" wire:loading.attr="disabled" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded transition flex items-center justify-center gap-2">
                    <span wire:loading.remove>Evaluate Now!</span>
                    <span wire:loading>স্ক্যান হচ্ছে, দয়া করে অপেক্ষা করুন...</span>
                </button>
            </div>
        @else
            <div class="bg-gray-50 rounded border p-6 text-center animate-fade-in">

                <div class="max-w-md mx-auto mb-6 bg-white p-2 rounded-lg shadow-sm border">
                    <img src="{{ asset($result['result_image']) }}" alt="Evaluated OMR" class="w-full h-auto rounded border">
                    <span class="text-xs text-green-600 font-bold mt-2 block">✓ Evaluated in 0.07s!</span>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-2">🎉 মূল্যায়ন সম্পন্ন হয়েছে!</h3>
                <p class="text-gray-600 mb-6">পরীক্ষা: <span class="font-bold text-blue-600">{{ $result['exam_name'] }}</span></p>

                <div class="grid grid-cols-4 gap-4 mb-8">
                    <div class="bg-blue-50 p-4 rounded border border-blue-100">
                        <p class="text-xs text-blue-600 font-bold uppercase">মোট প্রশ্ন</p>
                        <p class="text-2xl font-bold text-blue-800">{{ $result['total_questions'] }}</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded border border-green-100">
                        <p class="text-xs text-green-600 font-bold uppercase">সঠিক উত্তর</p>
                        <p class="text-2xl font-bold text-green-800">{{ $result['correct'] }}</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded border border-red-100">
                        <p class="text-xs text-red-600 font-bold uppercase">ভুল উত্তর</p>
                        <p class="text-2xl font-bold text-red-800">{{ $result['wrong'] }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded border border-gray-200">
                        <p class="text-xs text-gray-600 font-bold uppercase">ফাঁকা রাখা</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $result['blank'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded border shadow-sm max-w-sm mx-auto mb-6">
                    <p class="text-sm text-gray-500 font-bold uppercase">সর্বমোট প্রাপ্ত নম্বর</p>
                    <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $result['obtained'] }}</p>
                </div>

                <button wire:click="$set('result', null)" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded transition">
                    নতুন ওএমআর মূল্যায়ন করুন
                </button>
            </div>
        @endif
    </div>
</div>

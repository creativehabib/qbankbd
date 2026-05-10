<div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-6xl mx-auto bg-white rounded shadow-sm border border-gray-200 p-6">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                আমার তৈরী OMR টোকেন
            </h1>
            <button wire:click="openModal" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-5 rounded transition">
                + New Token
            </button>
        </div>

        @if (session()->has('success_message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md font-semibold">
                {{ session('success_message') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded border border-gray-200 bg-white">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left">

                <thead class="bg-gray-100 text-gray-700 font-bold">
                <tr>
                    <th class="px-6 py-4">টাইটেল</th>
                    <th class="px-6 py-4">টেমপ্লেট</th>
                    <th class="px-6 py-4">OMR কোড</th>
                    <th class="px-6 py-4">মোট প্রশ্ন</th>
                    <th class="px-6 py-4">নেগেটিভ মার্কিং</th>
                    <th class="px-6 py-4 text-center">পদক্ষেপ</th>
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                @forelse($tokens as $token)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">

                        <td class="px-6 py-4 font-bold text-black">{{ $token->title }}</td>

                        <td class="px-6 py-4 font-medium">
                            @if(isset($token->template) && $token->template->type === 'signature')
                                <span class="bg-green-600 text-white px-3 py-1 rounded text-xs font-semibold">সিগনেচার</span>
                            @else
                                <span class="text-gray-800">{{ $token->template->name ?? 'সাধারণ' }}</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-800 font-medium">
                            {{ $token->template->unique_code ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-gray-800 font-medium">{{ $token->total_questions }}</td>

                        <td class="px-6 py-4 text-gray-800 font-medium">{{ floatval($token->negative_mark) }}</td>

                        <td class="px-6 py-4 flex justify-center gap-2">
                            <a href="{{ route('omr.evaluate', ['token' => $token->token_id]) }}"
                               class="border border-gray-300 text-black bg-white px-4 py-1.5 rounded hover:bg-gray-100 text-xs font-semibold transition">
                                Scan Now
                            </a>

                            <a href="{{ route('tokens.map-answers', $token->token_id) }}"
                               class="border border-gray-300 text-green-600 bg-white px-4 py-1.5 rounded hover:bg-green-50 text-xs font-semibold transition">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-gray-400">কোনো ওএমআর টোকেন তৈরি করা হয়নি এখনও।</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    @if($showModal)
        <div class="w-full fixed top-0 left-0 z-[100] h-[100vh] bg-black/30 flex justify-center items-center">
            <div class="w-full md:w-96 bg-slate-700 text-white rounded shadow-lg mx-2 overflow-auto max-h-[90vh]">

                <div class="flex text-lg items-center justify-between px-3 py-2">
                    <p class="font-semibold bangla text-white">নতুন টোকেন তৈরী</p>
                    <div wire:click="closeModal" class="text-gray-600 cursor-pointer hover:bg-gray-200 flex items-center justify-center text-lg bg-gray-100 rounded h-7 w-7 transition">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 384 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                            <path d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"></path>
                        </svg>
                    </div>
                </div>

                <div class="bg-white p-4 text-black">
                    <div class="flex items-start gap-3 p-4 transition-all duration-200 bg-green-50 text-green-800 border border-green-200 rounded-lg">
                        <div class="text-green-500 text-xl mt-1">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-xs leading-relaxed text-green-900">
                                টোকেন এর মধ্যে আপনার পরীক্ষার উত্তরপত্র, কোন OMR টেমপ্লেট এ পরীক্ষা নিয়েছেন এই তথ্য গুলো থাকবে।
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="generateToken">
                        <div class="bg-white mt-3">
                            <input wire:model="title" class="my-1 w-full border rounded p-2 focus:ring-2 focus:ring-green-400 focus:outline-none" type="text" placeholder="পরীক্ষা বা একটি টাইটেল দিন">
                            @error('title') <span class="text-red-500 text-xs mb-2 block">{{ $message }}</span> @enderror

                            <div class="my-3">
                                <p class="mb-2 font-semibold text-gray-700 text-sm">OMR Template নির্বাচন করুন</p>
                                <div class="flex gap-4">
                                    @foreach($templates as $template)
                                        <div wire:click="selectTemplate({{ $template->id }}, '{{ $template->type }}')"
                                             class="relative border-2 rounded-lg cursor-pointer transition-all duration-200 p-1 w-36 text-center
                                             {{ $selectedTemplateId == $template->id ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:border-green-400' }}">

                                            <img src="/assets/img/{{ $template->type == 'signature' ? 'signature_thumb.jpg' : 'omr_sample.webp' }}"
                                                 alt="{{ $template->name }}"
                                                 class="h-28 w-full object-contain rounded p-1">

                                            <div class="absolute top-1 right-1">
                                                @if($selectedTemplateId == $template->id)
                                                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" class="text-green-500 text-xl" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M504 256c0 136.967-111.033 248-248 248S8 392.967 8 256 119.033 8 256 8s248 111.033 248 248zM227.314 387.314l184-184c6.248-6.248 6.248-16.379 0-22.627l-22.627-22.627c-6.248-6.249-16.379-6.249-22.628 0L216 308.118l-70.059-70.059c-6.248-6.248-16.379-6.248-22.628 0l-22.627 22.627c-6.248 6.248-6.248 16.379 0 22.627l104 104c6.249 6.249 16.379 6.249 22.628.001z"></path>
                                                    </svg>
                                                @else
                                                    <div class="w-5 h-5 border border-gray-400 bg-white rounded-full"></div>
                                                @endif
                                            </div>

                                            <div class="text-center mt-1 text-xs text-gray-700 font-medium">
                                                {{ $template->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('selectedTemplateId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            @if($templateType !== 'signature')
                                <div class="flex gap-2 my-2 transition-all duration-300">
                                    <div class="w-full">
                                        <input wire:model="unique_code" type="text" class="border rounded p-2 w-full focus:ring-2 focus:ring-green-400 focus:outline-none" placeholder="OMR Sheet Code">
                                        @error('unique_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full">
                                        <input wire:model="totalQuestions" type="number" class="border rounded p-2 w-full focus:ring-2 focus:ring-green-400 focus:outline-none" placeholder="Total Question">
                                        @error('totalQuestions') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="mt-2">
                                <select wire:model="negativeMark" class="border rounded p-2 w-full focus:ring-2 focus:ring-green-400 focus:outline-none text-gray-700">
                                    <option value="">Negetive Marks</option>
                                    <option value="0">0</option>
                                    <option value="0.25">0.25</option>
                                    <option value="0.5">0.5</option>
                                </select>
                                @error('negativeMark') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="bg-green-500 text-white hover:bg-green-600 w-full py-2 mt-5 flex items-center gap-2 justify-center rounded-md font-bold transition">
                                Generate Token
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif
</div>

<div class="dashboard print:p-0 lg:flex lg:justify-center">
    @php($theme = $this->themeClassSet())

    <div class="print:p-0 bg-gray-100 print:min-h-[297mm] print:bg-white">
        <div class="lg:hidden print:hidden px-4 mb-2 bg-white p-2 flex items-center justify-between">
            <button class="flex gap-1 items-center py-2 bg-amber-300 hover:bg-amber-200 px-2 rounded">
                কাস্টমাইজ
            </button>
            <button onclick="window.print()" class="flex gap-1 items-center py-2 bg-green-500 hover:bg-green-400 px-3 rounded text-white">
                ডাউনলোড
            </button>
        </div>

        <div class="flex gap-5 bg-gray-100 bangla print:gap-0 print:mx-0">
            <div class="overflow-auto print:overflow-visible select-none">
                <div class="omr-generator bangla h-[297mm] w-[210mm] print:p-0 bg-white border print:border-0 print:m-0">
                    <div class="py-5">
                        <div class="relative w-[750px] mx-auto">
                            <div class="header_clearence h-10"></div>

                            <div class="mx-10">
                                <div class="w-[664px] mx-auto">
                                    <div class="h-[72px] overflow-hidden center">
                                        <div class="leading-tight">
                                            <p class="text-center font-bold line-clamp-1" style="font-size: 24px;">{{ $schoolName }}</p>
                                            <p class="text-center font-bold line-clamp-1" style="font-size: 16px;">{{ $address }}</p>
                                        </div>
                                    </div>

                                    <div class="my-3 flex justify-between items-center">
                                        <div class="text-sm font-semibold {{ $theme['border'] }} border rounded px-3 py-1">
                                            {{ $headerSize === 'BIG' ? 'বড় হেডার' : 'ছোট হেডার' }}
                                        </div>
                                        <div class="text-sm font-semibold {{ $theme['border'] }} border rounded px-3 py-1">
                                            {{ $infoType === 'DIGITAL' ? 'ডিজিটাল তথ্য' : 'ম্যানুয়াল তথ্য' }}
                                        </div>
                                    </div>

                                    <div class="{{ $theme['border'] }} border rounded overflow-hidden">
                                        <div class="grid grid-cols-5 text-center text-xs font-bold bg-gray-50">
                                            <div class="py-2 border-r {{ $theme['border'] }}">প্রশ্ন</div>
                                            <div class="py-2 border-r {{ $theme['border'] }}">ক</div>
                                            <div class="py-2 border-r {{ $theme['border'] }}">খ</div>
                                            <div class="py-2 border-r {{ $theme['border'] }}">গ</div>
                                            <div class="py-2">ঘ</div>
                                        </div>

                                        @for ($question = 1; $question <= $questionCount; $question++)
                                            <div class="grid grid-cols-5 text-center text-xs border-t {{ $theme['border'] }}">
                                                <div class="py-1 border-r {{ $theme['border'] }}">{{ $this->toBanglaNumber($question) }}</div>
                                                @foreach (['ক', 'খ', 'গ', 'ঘ'] as $index => $option)
                                                    <div class="py-1 {{ $index < 3 ? 'border-r '.$theme['border'] : '' }} {{ $index % 2 === 0 ? $theme['bg'] : '' }}">
                                                        <span class="inline-flex items-center justify-center w-[18px] h-[18px] border border-black/60 rounded-full">{{ $option }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endfor
                                    </div>

                                    <p class="mt-2 text-sm font-medium">Questions: {{ $questionCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden shrink-0 fixed top-0 right-0 z-[1000] lg:z-0 bg-white lg:bg-none lg:sticky lg:block lg:top-16 h-screen sidebar w-80 google-shadow print:hidden overflow-y-auto">
                <div class="p-3">
                    <div class="bangla p-2">
                        <div class="py-2 bg-gray-200 text-center">সেটিংস</div>

                        <div class="mt-2">
                            <button onclick="window.print()" class="center w-full gap-1 items-center py-2 bg-green-500 hover:bg-green-400 px-3 rounded text-white">
                                ডাউনলোড
                            </button>
                        </div>

                        <div class="bg-gray-100 rounded-lg py-4 px-2 my-2">
                            <label class="block text-sm font-medium text-gray-600 mb-2">ব্রান্ডিং</label>
                            <input wire:model.live="schoolName" type="text" placeholder="প্রতিষ্ঠানের নাম" class="w-full rounded border-gray-300">
                            <input wire:model.live="address" type="text" placeholder="ঠিকানা" class="w-full rounded border-gray-300 mt-2">
                        </div>

                        <div class="p-2 bg-white rounded border border-gray-200 w-full">
                            <h2 class="text-xl font-semibold mb-5 text-gray-700">সিগনেচার কাস্টমাইজ অপশন্স</h2>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">থিম নির্বাচন করুন</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach (['rose', 'blue', 'green'] as $color)
                                            <button wire:click="updateTheme('{{ $color }}')" class="h-10 rounded border-2 transition {{ $themeColor === $color ? 'border-black' : 'border-transparent' }} bg-{{ $color }}-500"></button>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">হেডার নির্বাচন করুন</label>
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach (['SMALL', 'BIG'] as $size)
                                            <button wire:click="$set('headerSize', '{{ $size }}')" class="px-4 py-2 rounded-lg border text-sm font-medium transition {{ $headerSize === $size ? 'bg-rose-500 text-white border-rose-500' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">{{ $size }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">তথ্যের টাইপ</label>
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach (['DIGITAL', 'MANUAL'] as $type)
                                            <button wire:click="$set('infoType', '{{ $type }}')" class="px-4 py-2 rounded-lg border text-sm font-medium transition {{ $infoType === $type ? 'bg-rose-500 text-white border-rose-500' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">{{ $type }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-2">প্রশ্ন সংখ্যা</label>
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach ([40, 60, 80, 100] as $count)
                                            <button wire:click="$set('questionCount', {{ $count }})" class="px-3 py-2 rounded-lg border text-sm font-medium transition {{ $questionCount === $count ? 'bg-rose-500 text-white border-rose-500' : 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200' }}">{{ $count }}</button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border border-emerald-500 rounded p-2 text-center mt-5">
                            <div class="flex items-center gap-1 justify-center text-emerald-700">This OMR is scannable.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

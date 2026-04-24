<div class="p-4 space-y-4 bangla">
    @php($classes = $this->themeClasses())

    <div class="bg-white border rounded-lg p-4 shadow-sm">
        <h1 class="text-2xl font-bold">{{ $schoolName }}</h1>
        <p class="text-sm text-gray-600">{{ $address }}</p>

        <div class="mt-3 flex flex-wrap gap-2">
            <button wire:click="updateTheme('rose')" class="px-3 py-1.5 text-white rounded {{ $classes['button'] }}">Rose</button>
            <button wire:click="updateTheme('blue')" class="px-3 py-1.5 text-white rounded bg-blue-600 hover:bg-blue-700">Blue</button>
            <button wire:click="updateTheme('green')" class="px-3 py-1.5 text-white rounded bg-green-600 hover:bg-green-700">Green</button>
        </div>

        <div class="mt-2 text-xs text-gray-500">
            <span>Header: {{ $headerSize }}</span>
            <span class="mx-2">•</span>
            <span>Info: {{ $infoType }}</span>
            <span class="mx-2">•</span>
            <span>Questions: {{ $questionCount }}</span>
        </div>
    </div>

    <div class="flex gap-2 flex-wrap">
        @for ($i = 1; $i <= $questionCount; $i++)
            <div class="flex mt-[1px] border w-[160px] {{ $classes['border'] }}">
                <div class="w-[38px] text-center border-r p-[1px] text-xs {{ $classes['border'] }}">
                    {{ $this->toBanglaNumber($i) }}
                </div>
                <div class="text-center flex-1 grid grid-cols-4">
                    @foreach (['ক', 'খ', 'গ', 'ঘ'] as $option)
                        <div class="border-r last:border-r-0 center p-[1px] {{ $classes['option'] }}">
                            <p class="border border-black/60 rounded-full w-[18px] h-[18px] text-xs center">{{ $option }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="p-4 space-y-4 bangla">
    <div class="bg-white border rounded-lg p-4 shadow-sm space-y-3">
        <div class="grid gap-3 md:grid-cols-2">
            <div>
                <label class="text-xs text-gray-500">School Name</label>
                <input wire:model.live="schoolName" type="text" class="mt-1 w-full rounded border-gray-300" />
            </div>
            <div>
                <label class="text-xs text-gray-500">Address</label>
                <input wire:model.live="address" type="text" class="mt-1 w-full rounded border-gray-300" />
            </div>
        </div>

        <div class="grid gap-3 md:grid-cols-3">
            <div>
                <label class="text-xs text-gray-500">Question Count</label>
                <select wire:model.live="questionCount" class="mt-1 w-full rounded border-gray-300">
                    @foreach ([40, 60, 80, 100] as $count)
                        <option value="{{ $count }}">{{ $count }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Header Size</label>
                <select wire:model.live="headerSize" class="mt-1 w-full rounded border-gray-300">
                    <option value="BIG">BIG</option>
                    <option value="SMALL">SMALL</option>
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Info Type</label>
                <select wire:model.live="infoType" class="mt-1 w-full rounded border-gray-300">
                    <option value="DIGITAL">DIGITAL</option>
                    <option value="MANUAL">MANUAL</option>
                </select>
            </div>
        </div>

        <div class="flex gap-2 flex-wrap">
            <button wire:click="updateTheme('rose')" class="px-3 py-1.5 text-white rounded bg-rose-600 hover:bg-rose-700">Rose</button>
            <button wire:click="updateTheme('blue')" class="px-3 py-1.5 text-white rounded bg-blue-600 hover:bg-blue-700">Blue</button>
            <button wire:click="updateTheme('green')" class="px-3 py-1.5 text-white rounded bg-green-600 hover:bg-green-700">Green</button>
        </div>

        <div class="border rounded p-3">
            <h1 class="font-bold leading-tight {{ $headerSize === 'SMALL' ? 'text-lg' : 'text-2xl' }}">{{ $schoolName }}</h1>
            <p class="text-sm text-gray-600">{{ $address }}</p>
            <div class="mt-2 text-xs text-gray-500">
                <span>Header: {{ $headerSize }}</span>
                <span class="mx-2">•</span>
                <span>Info: {{ $infoType }}</span>
                <span class="mx-2">•</span>
                <span>Questions: {{ $questionCount }}</span>
            </div>
        </div>
    </div>

    <div class="flex gap-2 flex-wrap">
        @for ($i = 1; $i <= $questionCount; $i++)
            <div class="flex mt-[1px] border border-{{ $themeColor }}-500 w-[160px]">
                <div class="w-[38px] text-center border-r p-[1px] border-{{ $themeColor }}-500 text-xs">
                    {{ $this->toBanglaNumber($i) }}
                </div>
                <div class="text-center flex-1 grid grid-cols-4">
                    @foreach (['ক', 'খ', 'গ', 'ঘ'] as $option)
                        <div class="bg-{{ $themeColor }}-300/70 border-r last:border-r-0 border-{{ $themeColor }}-500 center p-[1px]">
                            <p class="border border-black/60 rounded-full w-[18px] h-[18px] text-xs center">{{ $option }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="p-4 space-y-4 bangla">
    @php($classes = $this->themeClasses())

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
                    @foreach ($this->questionCountOptions() as $count)
                        <option value="{{ $count }}">{{ $count }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Header Size</label>
                <select wire:model.live="headerSize" class="mt-1 w-full rounded border-gray-300">
                    @foreach ($this->headerSizeOptions() as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-xs text-gray-500">Info Type</label>
                <select wire:model.live="infoType" class="mt-1 w-full rounded border-gray-300">
                    @foreach ($this->infoTypeOptions() as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-2">
            @foreach ($this->themeOptions() as $themeKey => $themeOption)
                <button
                    wire:click="updateTheme('{{ $themeKey }}')"
                    class="px-3 py-1.5 rounded transition {{ $themeColor === $themeKey ? 'text-white '.$themeOption['button'] : $themeOption['buttonMuted'] }}"
                >
                    {{ $themeOption['label'] }}
                </button>
            @endforeach
        </div>

        <div class="border rounded p-3 {{ $classes['border'] }}">
            <h1 class="text-2xl font-bold leading-tight {{ $headerSize === 'SMALL' ? 'text-lg' : 'text-2xl' }}">{{ $schoolName }}</h1>
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

<div class="print:p-0 lg:flex lg:justify-center">
    @php
        $theme = $this->themeClassSet();

        // Active button classes (uses theme colour for active state)
        $btnActive   = $theme['header'] . ' text-white border-transparent';
        $btnInactive = 'bg-gray-100 text-gray-700 border-gray-300 hover:bg-gray-200';

        // MCQ grid data
        $cols    = 4;
        $perCol  = (int) ceil($this->questionCount / $cols);
        $options = ['ক','খ','গ','ঘ'];

        // Barcode sequence: c = circle, b = black bar
        $seqIprosh   = ['c','b','b','b','c','b','b','b','b','b','b','c','b','c','b','c','c','b','b','b'];
        $seqStandard = ['b','b','c','b','b','b','b','b','b','c','b','b','b','b','b','c','c','b','c','c'];
    @endphp

    {{-- ════════════════════════════════════════════════════
         MOBILE TOP BAR
    ════════════════════════════════════════════════════ --}}
    <div class="lg:hidden print:hidden px-4 mb-2 bg-white p-2 flex items-center justify-between shadow-sm">
        <button
            x-data
            x-on:click="document.getElementById('omr-sidebar').classList.toggle('hidden')"
            class="flex gap-1 items-center py-2 bg-amber-300 hover:bg-amber-200 px-3 rounded text-sm font-medium">
            কাস্টমাইজ
        </button>
        <button onclick="window.print()"
                class="flex gap-1 items-center py-2 bg-green-500 hover:bg-green-400 px-3 rounded text-white text-sm font-medium">
            প্রিন্ট
        </button>
    </div>

    <div class="flex gap-5 bangla print:gap-0 print:mx-0">

        {{-- ════════════════════════════════════════════════
             OMR SHEET
        ════════════════════════════════════════════════ --}}
        <div class="overflow-auto print:overflow-visible select-none">
            <div class="omr-generator bangla h-[297mm] w-[210mm] print:p-0 bg-white border print:border-0 print:m-0">
                <div class="py-5">
                    <div class="relative w-[750px] mx-auto">

                        {{-- ── Corner markers ── --}}
                        @if($this->templateType === 'iproshbang')
                            <img src="{{ asset('assets/img/m1-aa369e81.svg') }}"   alt="TL" class="absolute top-0 left-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/mb-7544e7d7.svg') }}"   alt="TR" class="absolute top-0 right-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/md-0ad8925e.svg') }}"   alt="BL" class="absolute bottom-0 left-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/m100-3c4745ce.svg') }}" alt="BR" class="absolute bottom-0 right-0 w-10 h-10 pointer-events-none">
                        @else
                            <img src="{{ asset('assets/img/m1-aa369e81.svg') }}"   alt="TL" class="absolute top-0 left-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/mb-7544e7d7.svg') }}"   alt="TR" class="absolute top-0 right-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/md-0ad8925e.svg') }}"   alt="BL" class="absolute bottom-0 left-0 w-10 h-10 pointer-events-none">
                            <img src="{{ asset('assets/img/m100-3c4745ce.svg') }}" alt="BR" class="absolute bottom-0 right-0 w-10 h-10 pointer-events-none">
                        @endif

                        {{-- ── Top barcode strip ── --}}
                        <div class="absolute flex items-center justify-center top-0 left-1/2 -translate-x-1/2">
                            <div class="{{ $theme['bg50'] }} w-[660px] h-10">
                                <div class="text-center text-sm {{ $theme['text'] }} font-bold">এই বক্সে কোনো দাগ দেয়া যাবে না।</div>
                                <div class="center">
                                    <div class="flex flex-wrap gap-1">
                                        @php $seq = $this->templateType === 'iproshbang' ? $seqIprosh : $seqStandard; @endphp
                                        @foreach($seq as $s)
                                            @if($s === 'c')
                                                <div class="w-4 h-4 border border-black rounded-full bg-white"></div>
                                            @else
                                                <div class="w-3 h-4 bg-black"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── Left scan bars ── --}}
                        <div class="absolute flex items-center justify-center left-0 top-1/2"
                             style="transform: translateY(-50%) rotate(-90deg) translateY(50%) translateX(2px); transform-origin: left center;">
                            <div class="flex flex-row">
                                @for($i = 0; $i < 5; $i++)
                                    <div class="w-3 h-6 bg-black mx-[1px]"></div>
                                @endfor
                            </div>
                        </div>

                        {{-- ── Right scan bars ── --}}
                        <div class="absolute flex items-center justify-center right-0 top-1/2"
                             style="transform: translateY(-50%) rotate(90deg) translateY(50%) translateX(-2px); transform-origin: right center;">
                            <div class="flex flex-row">
                                @for($i = 0; $i < 5; $i++)
                                    <div class="w-3 h-6 bg-black mx-[1px]"></div>
                                @endfor
                            </div>
                        </div>

                        <div class="header_clearence h-10"></div>

                        <div class="mx-10">
                            <div class="w-[664px] mx-auto">

                                {{-- ════════════════════════════════════════════
                                     TEMPLATE: iproshbang  (BIG header)
                                ════════════════════════════════════════════ --}}
                                @if($this->templateType === 'iproshbang')

                                    {{-- School name & address --}}
                                    @if($this->headerSize === 'BIG')
                                        <div class="h-[72px] overflow-hidden center">
                                            <div class="leading-tight">
                                                <p class="text-center font-bold line-clamp-1" style="font-size: {{ $this->schoolNameSize ?? 24 }}px;">{{ $this->schoolName }}</p>
                                                <p class="text-center font-bold line-clamp-1" style="font-size: {{ $this->addressSize }}px;">{{ $this->address }}</p>
                                            </div>
                                        </div>
                                    @else
                                        {{-- SMALL header: side-by-side --}}
                                        <div class="flex items-center justify-between border-b-2 border-black/40 pb-1 mb-2">
                                            <div class="leading-tight">
                                                <p class="font-bold line-clamp-1" style="font-size: {{ $this->schoolNameSize }}px;">{{ $this->schoolName }}</p>
                                                <p class="font-bold line-clamp-1" style="font-size: {{ $this->addressSize }}px;">{{ $this->address }}</p>
                                            </div>
                                            <p class="font-bold text-sm {{ $theme['text'] }}">বহুনির্বাচনি উত্তরপত্র</p>
                                        </div>
                                    @endif

                                    {{-- ── Info section ── --}}
                                    <div class="my-3">
                                        <div class="flex justify-between">
                                            <div class="flex gap-2.5">

                                                @if($this->infoType === 'DIGITAL')

                                                    {{-- শ্রেণি --}}
                                                    <div class="w-[90px]">
                                                        <div class="border {{ $theme['border'] }} pb-4">
                                                            <div class="border-b {{ $theme['border'] }} text-center font-bold">শ্রেণি</div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="border-r {{ $theme['border'] }}"></div>
                                                                <div class="border-r {{ $theme['border'] }} text-xs text-center">
                                                                    <div class="flex justify-center items-center border-b {{ $theme['border'] }} h-6"></div>
                                                                    @foreach(['৬','৭','৮','৯','১০','১১','১২'] as $cls)
                                                                        <div class="flex justify-center items-center border-b {{ $theme['border'] }} h-6">
                                                                            <span class="border rounded-full {{ $theme['border'] }} h-4 w-4 flex justify-center items-center">{{ $cls }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- রোল নম্বর (6 digits) --}}
                                                    <div class="border {{ $theme['border'] }}" style="width: 182px;">
                                                        <div class="border-b {{ $theme['border'] }} text-center font-bold">রোল নম্বর</div>
                                                        <div class="grid grid-cols-6">
                                                            @for($col = 0; $col < 6; $col++)
                                                                <div class="border-r {{ $theme['border'] }} h-6 {{ $col === 5 ? 'border-r-0' : '' }}"></div>
                                                            @endfor
                                                        </div>
                                                        <div class="grid grid-cols-6 border-t {{ $theme['border'] }}">
                                                            @for($col = 0; $col < 6; $col++)
                                                                @php
                                                                    $shaded  = ($col % 2 === 0) ? $theme['bg'] : '';
                                                                    $noRight = ($col === 5) ? 'border-r-0' : '';
                                                                @endphp
                                                                <div class="border-r {{ $theme['border'] }} text-center text-xs {{ $shaded }} {{ $noRight }}">
                                                                    @for($d = 0; $d <= 9; $d++)
                                                                        @php $noBorder = ($d === 9) ? '' : 'border-b '.$theme['border']; @endphp
                                                                        <div class="{{ $noBorder }} center p-[1px]">
                                                                            <div class="border border-black/60 rounded-full w-[18px] h-[18px] text-xs">{{ $this->toBanglaNumber($d) }}</div>
                                                                        </div>
                                                                    @endfor
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    {{-- বিষয় কোড (3 digits) --}}
                                                    <div class="border {{ $theme['border'] }}" style="width: 92px;">
                                                        <div class="border-b {{ $theme['border'] }} text-center font-bold">বিষয় কোড</div>
                                                        <div class="grid grid-cols-3">
                                                            @for($col = 0; $col < 3; $col++)
                                                                <div class="border-r {{ $theme['border'] }} h-6 {{ $col === 2 ? 'border-r-0' : '' }}"></div>
                                                            @endfor
                                                        </div>
                                                        <div class="grid grid-cols-3 border-t {{ $theme['border'] }}">
                                                            @for($col = 0; $col < 3; $col++)
                                                                @php
                                                                    $shaded  = ($col % 2 === 0) ? $theme['bg'] : '';
                                                                    $noRight = ($col === 2) ? 'border-r-0' : '';
                                                                @endphp
                                                                <div class="border-r {{ $theme['border'] }} text-center text-xs {{ $shaded }} {{ $noRight }}">
                                                                    @for($d = 0; $d <= 9; $d++)
                                                                        @php $noBorder = ($d === 9) ? '' : 'border-b '.$theme['border']; @endphp
                                                                        <div class="{{ $noBorder }} center p-[1px]">
                                                                            <div class="border border-black/60 rounded-full w-[18px] h-[18px] text-xs">{{ $this->toBanglaNumber($d) }}</div>
                                                                        </div>
                                                                    @endfor
                                                                </div>
                                                            @endfor
                                                        </div>
                                                    </div>

                                                    {{-- সেট কোড --}}
                                                    <div class="w-[90px]">
                                                        <div class="border {{ $theme['border'] }} pb-4">
                                                            <div class="border-b {{ $theme['border'] }} text-center font-bold">সেট কোড</div>
                                                            <div class="grid grid-cols-3">
                                                                <div class="border-r {{ $theme['border'] }}"></div>
                                                                <div class="border-r {{ $theme['border'] }} text-xs text-center">
                                                                    <div class="flex justify-center items-center border-b {{ $theme['border'] }} h-6"></div>
                                                                    @foreach(['ক','খ','গ','ঘ','ঙ','চ'] as $s)
                                                                        <div class="flex justify-center items-center border-b {{ $theme['border'] }} h-6">
                                                                            <span class="border rounded-full {{ $theme['border'] }} h-4 w-4 flex justify-center items-center">{{ $s }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                <div></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @else
                                                    {{-- MANUAL info --}}
                                                    <div class="flex-1 flex flex-col gap-3">
                                                        <div class="flex gap-5">
                                                            <div class="flex-1 flex gap-2 font-bold items-end">
                                                                <p>নাম:</p>
                                                                <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                            </div>
                                                            <div class="w-56 flex gap-2 font-bold items-end">
                                                                <p>রোল:</p>
                                                                <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                            </div>
                                                        </div>
                                                        <div class="flex gap-5">
                                                            <div class="flex-1 flex gap-2 font-bold items-end">
                                                                <p>শ্রেণি:</p>
                                                                <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                            </div>
                                                            <div class="w-56 flex gap-2 font-bold items-end">
                                                                <p>বিষয়:</p>
                                                                <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                            </div>
                                                            <div class="w-56 flex gap-2 font-bold items-end">
                                                                <p>বিভাগ:</p>
                                                                <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>{{-- end flex gap --}}

                                            {{-- নিয়মাবলী + স্বাক্ষর --}}
                                            <div class="w-[168px]">
                                                <div class="flex-1 h-full flex flex-col justify-between">
                                                    <div>
                                                        <div class="{{ $theme['header'] }} text-white text-center">
                                                            <p class="text-[12px] font-bold">নিয়মাবলী</p>
                                                        </div>
                                                        <div class="text-[11px] leading-tight text-justify">
                                                            <p>১। বৃত্তাকার ঘরগুলো এমন ভাবে ভরাট করতে হবে যাতে ভেতরের লেখাটি দেখা না যায়।</p>
                                                            <p>২। উত্তরপত্রে অবাঞ্চিত দাগ দেয়া যাবেনা।</p>
                                                            <p>৩। উত্তরপত্র ভাজ করা যাবেনা।</p>
                                                            <p>৪। সেট কোডবিহীন উত্তরপত্র বাতিল হবে।</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-end gap-1 my-4 h-10"></div>
                                                    <div class="border {{ $theme['border'] }} flex-1 mt-0.5 relative" style="min-height:44px;">
                                                        <p class="absolute bottom-2 text-xs text-center w-full">কক্ষ পরিদর্শকের স্বাক্ষর তারিখসহ</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>{{-- /my-3 --}}


                                    {{-- ════════════════════════════════════════════
                                         TEMPLATE: standard  (SMALL / compact)
                                    ════════════════════════════════════════════ --}}
                                @else

                                    {{-- Two-column compact header --}}
                                    <div class="my-2">
                                        <div class="grid grid-cols-2 border-b-2 border-black/70 pb-1">

                                            {{-- Left: school name + exam type checkboxes --}}
                                            <div class="flex items-center gap-2">
                                                <div class="w-full flex-1 h-full">
                                                    <div class="h-14 font-bold text-center line-clamp-2 center"
                                                         style="font-size: {{ $this->schoolNameSize }}px;">{{ $this->schoolName }}</div>
                                                    <div class="font-bold w-full">
                                                        <div class="grid grid-cols-2 text-sm">
                                                            @foreach(['অর্ধ-বার্ষিক পরীক্ষা','মডেল টেস্ট পরীক্ষা','বার্ষিক পরীক্ষা','................ পরীক্ষা'] as $examType)
                                                                <div class="flex gap-1 items-center">
                                                                    <div class="border-2 {{ $theme['border'] }} h-4 w-4 flex-shrink-0"></div>
                                                                    {{ $examType }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Right: rules + QR + set code --}}
                                            <div>
                                                <div class="flex gap-2">
                                                    <div class="flex flex-1 gap-2">
                                                        <div class="{{ $theme['header'] }} text-white flex items-center justify-center w-5 flex-shrink-0">
                                                            <p class="-rotate-90 text-[12px] font-bold whitespace-nowrap">নিয়মাবলী</p>
                                                        </div>
                                                        <div class="text-[11px] leading-tight">
                                                            <p>১। বৃত্তাকার ঘরগুলো এমন ভাবে ভরাট করতে হবে যাতে ভেতরের লেখাটি দেখা না যায়।</p>
                                                            <p>২। উত্তরপত্রে কোন অবাঞ্চিত দাগ দেয়া যাবেনা।</p>
                                                            <p>৩। উত্তরপত্র কোন ভাবেই ভাজ করা যাবেনা।</p>
                                                            <p>৪। সেট কোড না ভরাট করলে উত্তরপত্র বাতিল হবে।</p>
                                                        </div>
                                                    </div>
                                                    {{-- QR placeholder --}}
                                                    <div class="border h-[72px] w-[72px] border-black p-1 flex-shrink-0">
                                                        @if(file_exists(public_path('assets/img/qr-code.png')))
                                                            <img src="{{ asset('assets/img/qr-code.png') }}" alt="QR" class="w-full h-full object-contain">
                                                        @else
                                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-[9px] text-gray-500">QR</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- Set code row --}}
                                                <div class="border {{ $theme['border'] }} grid grid-cols-2 mt-1">
                                                    <p class="border-r text-center {{ $theme['border'] }} py-0.5 text-sm font-medium">প্রশ্নের সেট কোড</p>
                                                    <div class="flex justify-evenly gap-2 p-0.5">
                                                        @foreach(['ক','খ','গ','ঘ'] as $sc)
                                                            <div class="center">
                                                                <span class="center border {{ $theme['border'] }} rounded-full h-5 w-5 text-xs">{{ $sc }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- Student info (write-in lines) --}}
                                        <div class="my-1.5">
                                            <div class="flex gap-5">
                                                <div class="flex-1 flex gap-2 font-bold items-end">
                                                    <p>নাম:</p>
                                                    <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                </div>
                                                <div class="w-56 flex gap-2 font-bold items-end">
                                                    <p>রোল:</p>
                                                    <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                </div>
                                            </div>
                                            <div class="flex gap-5 mt-3">
                                                <div class="flex-1 flex gap-2 font-bold items-end">
                                                    <p>শ্রেণি:</p>
                                                    <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                </div>
                                                <div class="w-56 flex gap-2 font-bold items-end">
                                                    <p>বিষয়:</p>
                                                    <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                </div>
                                                <div class="w-56 flex gap-2 font-bold items-end">
                                                    <p>বিভাগ:</p>
                                                    <p class="flex-1 border border-dashed {{ $theme['border'] }}"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                {{-- ════════════ end template switch ════════════ --}}


                                {{-- ── MCQ Grid (shared by both templates) ── --}}
                                <p class="text-center font-bold mb-2">বহুনির্বাচনি অভিক্ষার উত্তরপত্র</p>

                                <div>
                                    <div class="flex gap-2">
                                        @for($col = 0; $col < $cols; $col++)
                                            @php
                                                $start = $col * $perCol + 1;
                                                $end   = min($start + $perCol - 1, $this->questionCount);
                                            @endphp
                                            <div class="w-[160px] text-xs">
                                                {{-- Column header --}}
                                                <div class="flex border {{ $theme['border'] }} font-bold h-[25px]">
                                                    <div class="w-[38px] text-center border-r {{ $theme['border'] }} py-1">প্রশ্ন</div>
                                                    <div class="flex-1 text-center py-1">উত্তর</div>
                                                </div>
                                                {{-- Question rows --}}
                                                @for($q = $start; $q <= $end; $q++)
                                                    <div class="flex mt-[1px] border {{ $theme['border'] }} w-[160px]">
                                                        <div class="w-[38px] text-center border-r p-[1px] {{ $theme['border'] }} text-xs center">
                                                            {{ $this->toBanglaNumber($q) }}
                                                        </div>
                                                        <div class="text-center flex-1 grid grid-cols-4">
                                                            @foreach($options as $oi => $opt)
                                                                @php
                                                                    $bgClass     = ($oi === 0 || $oi === 2) ? $theme['bg'] : '';
                                                                    $borderRight = ($oi < 3) ? 'border-r '.$theme['border'] : '';
                                                                @endphp
                                                                <div class="{{ $bgClass }} {{ $borderRight }} center p-[1px]">
                                                                    <p class="border border-black/60 rounded-full w-[18px] h-[18px] text-xs flex items-center justify-center">{{ $opt }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                            </div>{{-- /w-[664px] --}}
                        </div>{{-- /mx-10 --}}
                    </div>{{-- /relative --}}
                </div>{{-- /py-5 --}}
            </div>{{-- /omr-generator --}}
        </div>{{-- /overflow-auto --}}


        {{-- ════════════════════════════════════════════════
             SIDEBAR  (desktop sticky | mobile drawer)
        ════════════════════════════════════════════════ --}}
        <div id="omr-sidebar"
             class="hidden shrink-0 fixed top-0 right-0 z-[1000] lg:z-0 bg-white lg:bg-transparent
                    lg:sticky lg:block lg:top-16 h-screen w-80 shadow-lg lg:shadow-none
                    print:hidden overflow-y-auto">
            <div class="p-3 bg-white border">
                <div class="bangla p-2 space-y-3">

                    {{-- Header --}}
                    <div class="py-2 bg-gray-200 text-center rounded font-semibold tracking-wide">সেটিংস</div>

                    {{-- Print button --}}
                    <button onclick="window.print()"
                            class="center w-full gap-2 py-2 bg-green-500 hover:bg-green-400 px-3 rounded text-white font-semibold">
                        প্রিন্ট / ডাউনলোড
                    </button>

                    {{-- ── Branding ── --}}
                    <div class="bg-gray-100 rounded-lg py-4 px-3 space-y-2">
                        <label class="block text-sm font-semibold text-gray-600">ব্রান্ডিং</label>

                        <input wire:model.live="schoolName" type="text"
                               placeholder="প্রতিষ্ঠানের নাম"
                               class="w-full rounded border border-gray-300 px-2 py-1 text-sm focus:outline-none focus:border-rose-400">

                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-8">Size</span>
                            <input wire:model.live="schoolNameSize" type="range" min="10" max="30" step="1" class="flex-1">
                            <span class="text-xs w-6 text-right">{{ $this->schoolNameSize }}</span>
                        </div>

                        <input wire:model.live="address" type="text"
                               placeholder="ঠিকানা বা কাস্টম টেক্সট"
                               class="w-full rounded border border-gray-300 px-2 py-1 text-sm focus:outline-none focus:border-rose-400">

                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 w-8">Size</span>
                            <input wire:model.live="addressSize" type="range" min="10" max="20" step="1" class="flex-1">
                            <span class="text-xs w-6 text-right">{{ $this->addressSize }}</span>
                        </div>
                    </div>

                    {{-- ── Template selection ── --}}
                    <div>
                        <p class="text-sm font-semibold mb-2">টেমপ্লেট নির্বাচন করুন</p>
                        <div class="flex gap-2">
                            @php
                                $tplList = [
                                    'iproshbang' => ['img' => '/assets/img/signature_thumb.jpg', 'label' => 'ইপ্রশ্নব্যাংক সিগনেচার'],
                                    'standard'   => ['img' => '/assets/img/omr_sample.webp',      'label' => 'সাধারণ'],
                                ];
                            @endphp
                            @foreach($tplList as $tKey => $tData)
                                @php $tActive = $this->templateType === $tKey; @endphp
                                <div wire:click="$set('templateType', '{{ $tKey }}')"
                                     class="border-2 p-2 flex-1 rounded flex flex-col items-center justify-center cursor-pointer transition
                                            {{ $tActive ? 'border-gray-800 bg-gray-50' : 'border-transparent hover:border-gray-400' }}">
                                    @if(file_exists(public_path(ltrim($tData['img'], '/'))))
                                        <img src="{{ asset(ltrim($tData['img'],'/')) }}" alt="" class="w-full h-auto rounded">
                                    @else
                                        <div class="w-full h-14 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">preview</div>
                                    @endif
                                    <p class="mt-2 text-xs font-medium text-gray-700 text-center">{{ $tData['label'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ── Customize options ── --}}
                    <div class="bg-white rounded border border-gray-200 p-3 space-y-4">
                        <h2 class="text-base font-semibold text-gray-700">কাস্টমাইজ অপশন্স</h2>

                        {{-- Theme --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">থিম নির্বাচন করুন</label>
                            <div class="grid grid-cols-5 gap-2">
                                @php
                                    $themeMap = [
                                        'rose'   => 'bg-rose-500',
                                        'gray'   => 'bg-gray-500',
                                        'blue'   => 'bg-blue-500',
                                        'green'  => 'bg-green-500',
                                        'purple' => 'bg-violet-500',
                                        'orange' => 'bg-orange-500',
                                        'cyan'   => 'bg-sky-500',
                                        'pink'   => 'bg-pink-500',
                                        'yellow' => 'bg-yellow-500',
                                        'lime'   => 'bg-lime-500',
                                    ];
                                @endphp
                                @foreach($themeMap as $tKey => $tBg)
                                    <button wire:click="updateTheme('{{ $tKey }}')"
                                            class="h-9 rounded border-2 transition {{ $tBg }}
                                                   {{ $this->themeColor === $tKey ? 'border-black scale-110' : 'border-transparent opacity-75 hover:opacity-100' }}"
                                            title="{{ $tKey }}">
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Header size (iproshbang only) --}}
                        @if($this->templateType === 'iproshbang')
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">হেডার সাইজ</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach(['SMALL', 'BIG'] as $hVal)
                                        <button wire:click="$set('headerSize', '{{ $hVal }}')"
                                                class="px-4 py-2 rounded-lg border text-sm font-medium transition
                                                   {{ $this->headerSize === $hVal ? $btnActive : $btnInactive }}">
                                            {{ $hVal }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Info type (iproshbang only) --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-2">তথ্যের ধরন</label>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach(['DIGITAL', 'MANUAL'] as $iVal)
                                        <button wire:click="$set('infoType', '{{ $iVal }}')"
                                                class="px-4 py-2 rounded-lg border text-sm font-medium transition
                                                   {{ $this->infoType === $iVal ? $btnActive : $btnInactive }}">
                                            {{ $iVal }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Question count --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-2">প্রশ্ন সংখ্যা</label>
                            <div class="flex gap-2 flex-wrap">
                                @foreach([40, 60, 80, 100] as $cnt)
                                    <button wire:click="$set('questionCount', {{ $cnt }})"
                                            class="px-3 py-2 rounded-lg border text-sm font-medium transition
                                                   {{ $this->questionCount === $cnt ? $btnActive : $btnInactive }}">
                                        {{ $cnt }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                    </div>{{-- /customize box --}}

                    {{-- Scannable badge --}}
                    <div class="border border-emerald-500 rounded p-2 text-center text-emerald-700 text-sm">
                        ✅ This OMR is scannable.
                    </div>

                </div>
            </div>
        </div>{{-- /sidebar --}}

    </div>{{-- /flex --}}
</div>{{-- /dashboard --}}
@push('styles')
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 0;
        }
    }
</style>
@endpush

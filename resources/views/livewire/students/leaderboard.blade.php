<div class="mx-auto max-w-2xl h-full">
    <div class="w-full bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">

        <div class="bg-gradient-to-b from-[#f59e0b] to-[#ea580c] dark:from-amber-700 dark:to-amber-900 px-6 py-8 text-center relative overflow-hidden">

            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute top-0 left-1/4 w-32 h-32 bg-white rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-40 h-40 bg-white rounded-full blur-3xl"></div>
            </div>

            <a href="#" class="absolute top-4 right-4 z-20 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-colors flex items-center gap-1.5 border border-white/20 shadow-sm">
                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                Hall of Fame
            </a>

            <div
                x-data="{
                    isDown: false,
                    startX: 0,
                    scrollLeft: 0,
                    dragged: false,
                    centerLeague() {
                        setTimeout(() => {
                            let active = this.$el.querySelector('.active-league-card');
                            if (active) {
                                let centerPos = active.offsetLeft - (this.$el.clientWidth / 2) + (active.clientWidth / 2);
                                this.$el.scrollTo({ left: centerPos, behavior: 'smooth' });
                            }
                        }, 100);
                    },
                    startDrag(e) {
                        this.isDown = true;
                        this.dragged = false;
                        this.startX = e.pageX - this.$el.offsetLeft;
                        this.scrollLeft = this.$el.scrollLeft;
                    },
                    doDrag(e) {
                        if (!this.isDown) return;
                        e.preventDefault();
                        const x = e.pageX - this.$el.offsetLeft;
                        const walk = x - this.startX;
                        if (Math.abs(walk) > 5) this.dragged = true;
                        this.$el.scrollLeft = this.scrollLeft - (walk * 1.5);
                    }
                }"
                x-init="
                    centerLeague();
                    document.addEventListener('livewire:navigated', () => centerLeague());
                "
                @mousedown="startDrag"
                @mouseleave="isDown = false"
                @mouseup="isDown = false"
                @mousemove="doDrag"
                class="select-none flex items-center gap-3 md:gap-5 mb-6 relative z-10 py-10 overflow-x-auto no-scrollbar cursor-grab active:cursor-grabbing px-[45%] scroll-smooth [mask-image:linear-gradient(to_right,transparent,black_15%,black_85%,transparent)]"
            >
                @foreach($leagues as $id => $league)
                    @php $isActive = $league_id == $id; @endphp

                    <a
                        href="?league_id={{ $id }}"
                        wire:navigate
                        draggable="false"
                        @click="if(dragged || {{ $isActive ? 'true' : 'false' }}) { $event.preventDefault(); return; }"
                        class="relative flex flex-col items-center transition-all duration-500 transform shrink-0
                               {{ $isActive ? 'active-league-card scale-[1.7] z-20 opacity-100 mx-5' : 'scale-90 opacity-40 hover:scale-110 hover:opacity-100 z-10 cursor-pointer' }}"
                    >
                        <div class="w-12 h-12 md:w-14 md:h-14 relative drop-shadow-xl transition-transform duration-300 {{ $isActive ? 'rounded-full' : '' }}">
                            <img src="https://sattacademy.com/images/icons/{{ $league['icon'] }}-league.png" draggable="false" class="w-full h-full object-contain pointer-events-none">
                        </div>

                        @if($myActualLeagueId == $id)
                            <div class="absolute -bottom-3 bg-blue-600 text-white text-[7px] md:text-[8px] font-black px-3 py-0.5 rounded-full shadow-lg border border-white/20 tracking-wider">YOU</div>
                        @endif
                    </a>
                @endforeach
            </div>

            <h2 class="text-3xl font-black text-white drop-shadow-md relative z-10 mt-2 transition-all">{{ $currentLeague['name'] }}</h2>
            <p class="flex w-full justify-center items-center gap-1 text-sm text-white/90 font-medium mt-1 relative z-10">
                <span>Top 20% advance to next League</span>
                <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </p>

            <div class="inline-flex items-center gap-1.5 mt-4 bg-white/20 backdrop-blur-md px-5 py-1.5 rounded-full relative z-10 border border-white/10 shadow-sm">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-sm text-white font-bold">{{ $timerText }}</span>
            </div>

            <div class="absolute text-white text-sm font-bold opacity-90 bottom-4 left-6">
                Total: {{ number_format($totalStudents) }}
            </div>
        </div>

        <div class="p-4 bg-zinc-50 dark:bg-zinc-900">
            @if($topStudents->isEmpty())
                <div class="py-10 text-center">
                    <p class="text-zinc-500 font-medium">এই লিগে এখনো কেউ পয়েন্ট পায়নি!</p>
                </div>
            @else
                <div class="space-y-2">
                    @foreach($topStudents->take(3) as $index => $student)
                        @php
                            $rank = $index + 1;

                            if ($rank === 1) {
                                $cardBg = "bg-[#fffbeb] border-[#fcd34d]";
                                $rankBadge = "bg-[#fbbf24] text-white";
                            } elseif ($rank === 2) {
                                $cardBg = "bg-white border-zinc-200";
                                $rankBadge = "text-zinc-500 bg-transparent";
                            } else {
                                $cardBg = "bg-[#fff7ed] border-[#fdba74]";
                                $rankBadge = "text-zinc-500 bg-transparent";
                            }
                        @endphp

                        <div class="flex items-center justify-between p-3.5 transition-all hover:scale-[1.02]  rounded-xl border-2 {{ $cardBg }} shadow-sm">
                            <div class="flex items-center gap-4">
                                <div class="w-8 text-center flex justify-center">
                                    @if($rank === 1)
                                        <div class="size-8 flex items-center justify-center rounded-full {{ $rankBadge }} shadow-sm">
                                            <svg class="size-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                        </div>
                                    @else
                                        <span class="font-bold text-zinc-500 text-lg">{{ $rank }}<sup class="text-[11px] font-semibold">{{ $rank===2 ? 'nd' : 'rd' }}</sup></span>
                                    @endif
                                </div>

                                <div class="size-12 overflow-hidden rounded-full bg-zinc-200 border-2 border-white shadow-sm flex items-center justify-center text-zinc-500 font-bold text-xl">
                                    {{ mb_substr($student->name, 0, 1) }}
                                </div>

                                <div>
                                    <span class="font-bold text-zinc-900 text-base block">
                                        {{ $student->name }}
                                        @if($student->id === auth()->id())
                                            <span class="text-blue-600 text-sm ml-1 font-semibold">(You)</span>
                                        @endif
                                    </span>
                                    @if($rank === 1)
                                        <span class="text-xs text-[#d97706] font-bold">League Leader</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5">
                                <svg class="w-5 h-5 text-[#fbbf24]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                <span class="font-black text-lg text-zinc-900">{{ number_format($student->xp) }} XP</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="border-t-[3px] border-dotted border-zinc-200 dark:border-zinc-700 my-6"></div>

                @if($myRank > 3)
                    <div class="flex items-center justify-between p-3.5 mb-3 rounded-xl border border-[#bbf7d0] bg-[#dcfce7] shadow-sm">
                        <div class="flex items-center gap-4">
                            <span class="w-8 text-center font-bold text-zinc-600 text-sm">{{ $myRank }}th</span>
                            <div class="size-10 overflow-hidden rounded-full border-2 border-white shadow-sm bg-zinc-200 flex items-center justify-center text-zinc-600 font-bold">
                                {{ mb_substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="font-bold text-zinc-900 text-base">
                                {{ auth()->user()->name }}
                                <span class="text-emerald-700 text-sm font-semibold ml-1">(You)</span>
                            </span>
                        </div>
                        <span class="font-bold text-sm text-zinc-800">{{ number_format(auth()->user()->xp ?? 0) }} XP</span>
                    </div>
                @endif

                <div class="space-y-1">
                    @foreach($topStudents->skip(3) as $index => $student)
                        @php
                            $rank = $index + 4;
                            $suffix = 'th';
                            if (!in_array(($rank % 100), [11, 12, 13])) {
                                switch ($rank % 10) {
                                    case 1:  $suffix = 'st'; break;
                                    case 2:  $suffix = 'nd'; break;
                                    case 3:  $suffix = 'rd'; break;
                                }
                            }
                        @endphp

                        @if($student->id !== auth()->id())
                            <div class="flex items-center justify-between p-3 rounded-xl bg-transparent hover:bg-zinc-100 transition-colors">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 text-center font-bold text-zinc-500 text-sm">{{ $rank }}{{ $suffix }}</span>
                                    <div class="size-10 overflow-hidden rounded-full bg-zinc-200 flex items-center justify-center text-zinc-600 font-bold">
                                        {{ mb_substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-zinc-800 text-base">
                                        {{ $student->name }}
                                        @if($student->id === auth()->id())
                                            <span class="text-emerald-600 text-sm font-semibold ml-1">(You)</span>
                                        @endif
                                    </span>
                                </div>
                                <span class="font-bold text-zinc-800 text-sm">{{ number_format($student->xp) }} XP</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<div x-data="{
        timeRemaining: @entangle('timeRemaining'),
        answers: @entangle('answers'),
        formattedTime() {
            let minutes = Math.floor(this.timeRemaining / 60);
            let seconds = this.timeRemaining % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        },
        submitExam() {
            $wire.submit();
        },
        playConfetti(event) {
            if (typeof confetti === 'undefined') {
                let script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js';
                script.onload = () => this.fireConfetti(event);
                document.head.appendChild(script);
            } else {
                this.fireConfetti(event);
            }
        },
        fireConfetti(event) {
            const rect = event.target.getBoundingClientRect();
            const x = (rect.left + (rect.width / 2)) / window.innerWidth;
            const y = (rect.top + (rect.height / 2)) / window.innerHeight;
            confetti({
                particleCount: 100,
                spread: 70,
                origin: { x: x, y: y },
                colors: ['#10B981', '#34D399', '#059669', '#FBBF24']
            });
        },
        playSound(isCorrect) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                
                osc.connect(gain);
                gain.connect(ctx.destination);
                
                if (isCorrect) {
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(523.25, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(1046.50, ctx.currentTime + 0.1);
                    
                    gain.gain.setValueAtTime(0, ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0.2, ctx.currentTime + 0.05);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.5);
                    
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.5);
                } else {
                    osc.type = 'square';
                    osc.frequency.setValueAtTime(150, ctx.currentTime);
                    osc.frequency.exponentialRampToValueAtTime(100, ctx.currentTime + 0.2);
                    
                    gain.gain.setValueAtTime(0, ctx.currentTime);
                    gain.gain.linearRampToValueAtTime(0.1, ctx.currentTime + 0.05);
                    gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.2);
                    
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + 0.2);
                }
            } catch(e) {}
        },
        init() {
            let timer = setInterval(() => {
                if (this.timeRemaining > 0) {
                    this.timeRemaining--;
                } else {
                    clearInterval(timer);
                    this.submitExam();
                }
            }, 1000);
        }
    }">
    
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4 sticky top-0 z-50 bg-zinc-50/90 dark:bg-zinc-950/90 backdrop-blur-md p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <div>
            <h1 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">{{ $modelTest->title }}</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">মোট প্রশ্ন: {{ count($questions) }} | নেগেটিভ মার্ক: {{ $modelTest->negative_mark_weight }}</p>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 bg-indigo-100 text-indigo-800 dark:bg-indigo-900/40 dark:text-indigo-300 px-4 py-2 rounded-lg font-mono font-bold text-xl border border-indigo-200 dark:border-indigo-800 shadow-inner">
                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span x-text="formattedTime()"></span>
            </div>
            
            <button type="button" @click="if(confirm('আপনি কি পরীক্ষা শেষ করে সাবমিট করতে চান?')) submitExam()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg shadow-sm transition">
                Submit Exam
            </button>
        </div>
    </div>

    <div class="space-y-6 max-w-4xl mx-auto">
        @foreach($questions as $index => $question)
            @php
                $options = is_string($question->extra_content) ? json_decode($question->extra_content, true) : $question->extra_content;
                $optionLabels = ['ক', 'খ', 'গ', 'ঘ', 'ঙ'];
                $correctIndex = null;
                if(is_array($options)) {
                    foreach($options as $idx => $opt) {
                        if(!empty($opt['is_correct'])) {
                            $correctIndex = $idx;
                            break;
                        }
                    }
                }
            @endphp
            
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="flex items-start gap-4 mb-4">
                    <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 text-sm font-extrabold flex items-center justify-center border border-indigo-200 dark:border-indigo-800">
                        {{ $index + 1 }}
                    </span>
                    <div class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                        {!! $question->title !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pl-12" 
                     x-data="{ 
                         correctIndex: '{{ $correctIndex }}',
                         isAnswered() {
                             return this.answers[{{ $question->id }}] !== null && this.answers[{{ $question->id }}] !== undefined && this.answers[{{ $question->id }}] !== '';
                         }
                     }">
                    @if(is_array($options))
                        @foreach($options as $optIndex => $option)
                            <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none transition-all"
                                :class="[
                                    isAnswered() ? 'pointer-events-none' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800',
                                    (isAnswered() && '{{ $optIndex }}' === correctIndex) ? 'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 ring-1 ring-emerald-500' : 
                                    (answers[{{ $question->id }}] == '{{ $optIndex }}' && answers[{{ $question->id }}] != correctIndex) ? 'border-rose-500 bg-rose-50 dark:bg-rose-900/20 ring-1 ring-rose-500' : 
                                    'border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-900'
                                ]">
                                
                                <input type="radio" x-model="answers[{{ $question->id }}]" value="{{ $optIndex }}" class="sr-only" :disabled="isAnswered()" @change="let isCorrect = ($el.value == correctIndex); playSound(isCorrect); if(isCorrect) playConfetti($event);">
                                
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span class="block text-sm font-medium" 
                                            :class="[
                                                (isAnswered() && '{{ $optIndex }}' === correctIndex) ? 'text-emerald-900 dark:text-emerald-100' : 
                                                (answers[{{ $question->id }}] == '{{ $optIndex }}' && answers[{{ $question->id }}] != correctIndex) ? 'text-rose-900 dark:text-rose-100' : 
                                                'text-zinc-900 dark:text-zinc-100'
                                            ]">
                                            <span class="font-bold mr-2">{{ $optionLabels[$optIndex] ?? ($optIndex+1) }}.</span>
                                            {!! strip_tags($option['option_text'] ?? '') !!}
                                        </span>
                                    </span>
                                </span>
                                
                                <svg class="h-5 w-5" 
                                    :class="[
                                        (isAnswered() && '{{ $optIndex }}' === correctIndex) ? 'text-emerald-600 block' : 
                                        (answers[{{ $question->id }}] == '{{ $optIndex }}' && answers[{{ $question->id }}] != correctIndex) ? 'text-rose-600 block' : 
                                        'hidden'
                                    ]" 
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path x-show="(isAnswered() && '{{ $optIndex }}' === correctIndex)" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    <path x-show="(answers[{{ $question->id }}] == '{{ $optIndex }}' && answers[{{ $question->id }}] != correctIndex)" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </label>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8 text-center max-w-4xl mx-auto">
        <button type="button" @click="if(confirm('আপনি কি পরীক্ষা শেষ করে সাবমিট করতে চান?')) submitExam()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition text-lg w-full md:w-auto">
            Submit Exam & Get Result
        </button>
    </div>
</div>


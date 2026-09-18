/**
 * BDNiyog Daily Study Streak & Target System
 * Concept: Duolingo-style daily study target (20 questions / day) with streak tracking.
 * Zero-server load: Tracks question views locally, syncs to server once daily target is met.
 */
(function () {
    'use strict';

    const TARGET_QUESTIONS = 20;
    const STORAGE_KEY_DATE = 'bdniyog_study_date';
    const STORAGE_KEY_QUESTIONS = 'bdniyog_study_questions';
    const STORAGE_KEY_SYNCED = 'bdniyog_streak_synced';
    const STORAGE_KEY_STREAK = 'bdniyog_current_streak';
    const STORAGE_KEY_LONGEST = 'bdniyog_longest_streak';
    const STORAGE_KEY_LAST_COMPLETED = 'bdniyog_last_completed_date';

    // Bengali numerals converter
    function toBnNum(num) {
        const bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return String(num ?? 0).replace(/[0-9]/g, d => bnDigits[d]);
    }

    // Get today's local date string YYYY-MM-DD
    function getTodayDateString() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Get yesterday's date string YYYY-MM-DD
    function getYesterdayDateString() {
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        const year = yesterday.getFullYear();
        const month = String(yesterday.getMonth() + 1).padStart(2, '0');
        const day = String(yesterday.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Global Toast Notification Helper
    if (typeof window.showToast !== 'function') {
        window.showToast = function (message, type = 'info') {
            let container = document.getElementById('global-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'global-toast-container';
                container.className = 'fixed bottom-5 right-5 z-[9999] flex flex-col gap-2 max-w-sm pointer-events-none';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            const isError = type === 'error' || type === 'danger';
            const isSuccess = type === 'success';

            const bgClass = isError
                ? 'bg-rose-600 text-white shadow-rose-600/30'
                : (isSuccess ? 'bg-emerald-600 text-white shadow-emerald-600/30' : 'bg-slate-900 text-white shadow-slate-900/30 dark:bg-slate-800 dark:border dark:border-slate-700');

            toast.className = `pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl text-sm font-semibold transition-all duration-300 transform translate-y-4 opacity-0 ${bgClass}`;
            toast.innerHTML = `
                <span class="text-base">${isError ? '⚠️' : (isSuccess ? '🎉' : '🔔')}</span>
                <span class="flex-1">${message}</span>
            `;

            container.appendChild(toast);

            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-4', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        };
    }

    const StreakManager = {
        getTodayState: function () {
            const today = getTodayDateString();
            const storedDate = localStorage.getItem(STORAGE_KEY_DATE);

            if (storedDate !== today) {
                // New day: reset today's question pool and sync flag
                localStorage.setItem(STORAGE_KEY_DATE, today);
                localStorage.setItem(STORAGE_KEY_QUESTIONS, JSON.stringify([]));
                localStorage.setItem(STORAGE_KEY_SYNCED, '0');

                // Check if streak broke yesterday (if not completed yesterday)
                const lastCompleted = localStorage.getItem(STORAGE_KEY_LAST_COMPLETED);
                const yesterday = getYesterdayDateString();
                if (lastCompleted && lastCompleted !== yesterday && lastCompleted !== today) {
                    // Missed yesterday, reset current streak locally for guest
                    if (!this.isAuthenticated()) {
                        localStorage.setItem(STORAGE_KEY_STREAK, '0');
                    }
                }
            }

            let questions = [];
            try {
                questions = JSON.parse(localStorage.getItem(STORAGE_KEY_QUESTIONS) || '[]');
            } catch (e) {
                questions = [];
            }

            const synced = localStorage.getItem(STORAGE_KEY_SYNCED) === '1';
            const currentStreak = parseInt(localStorage.getItem(STORAGE_KEY_STREAK) || '0', 10);
            const longestStreak = parseInt(localStorage.getItem(STORAGE_KEY_LONGEST) || '0', 10);
            const isCompletedToday = localStorage.getItem(STORAGE_KEY_LAST_COMPLETED) === today || synced;

            return {
                today,
                questions,
                count: questions.length,
                target: TARGET_QUESTIONS,
                synced,
                currentStreak,
                longestStreak,
                isCompletedToday
            };
        },

        isAuthenticated: function () {
            const authMeta = document.querySelector('meta[name="streak-user-auth"]');
            return authMeta && authMeta.content === '1';
        },

        // Hydrate from server meta tags if authenticated
        hydrateFromMeta: function () {
            const isAuth = this.isAuthenticated();
            if (isAuth) {
                const streakMeta = document.querySelector('meta[name="streak-current"]');
                const longestMeta = document.querySelector('meta[name="streak-longest"]');
                const lastDateMeta = document.querySelector('meta[name="streak-last-date"]');

                if (streakMeta && streakMeta.content !== '') {
                    localStorage.setItem(STORAGE_KEY_STREAK, streakMeta.content);
                }
                if (longestMeta && longestMeta.content !== '') {
                    localStorage.setItem(STORAGE_KEY_LONGEST, longestMeta.content);
                }
                if (lastDateMeta && lastDateMeta.content !== '') {
                    localStorage.setItem(STORAGE_KEY_LAST_COMPLETED, lastDateMeta.content);
                }
            }
        },

        trackQuestion: function (rawQuestionId) {
            if (!rawQuestionId) return;
            const questionId = String(rawQuestionId).trim();
            if (!questionId) return;

            const state = this.getTodayState();
            if (state.questions.includes(questionId)) {
                return; // Already counted this question today
            }

            state.questions.push(questionId);
            localStorage.setItem(STORAGE_KEY_QUESTIONS, JSON.stringify(state.questions));

            const newCount = state.questions.length;
            this.updateUI(newCount, state.target, state.currentStreak, state.longestStreak, state.isCompletedToday);

            // Target reached!
            if (newCount >= TARGET_QUESTIONS && !state.synced && !state.isCompletedToday) {
                this.completeDailyTarget();
            }
        },

        completeDailyTarget: function () {
            const today = getTodayDateString();
            localStorage.setItem(STORAGE_KEY_SYNCED, '1');
            localStorage.setItem(STORAGE_KEY_LAST_COMPLETED, today);

            const isAuth = this.isAuthenticated();

            if (isAuth) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
                fetch('/api/user/study-streak/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ completed: true })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const newStreak = parseInt(data.current_streak || '1', 10);
                        const longest = parseInt(data.longest_streak || newStreak, 10);
                        localStorage.setItem(STORAGE_KEY_STREAK, String(newStreak));
                        localStorage.setItem(STORAGE_KEY_LONGEST, String(longest));
                        this.updateUI(TARGET_QUESTIONS, TARGET_QUESTIONS, newStreak, longest, true);
                        this.triggerCelebration(newStreak, data.message);
                    }
                })
                .catch(() => {
                    // Fallback to local increment
                    this.localTargetCelebration();
                });
            } else {
                this.localTargetCelebration();
            }
        },

        localTargetCelebration: function () {
            let current = parseInt(localStorage.getItem(STORAGE_KEY_STREAK) || '0', 10) + 1;
            let longest = parseInt(localStorage.getItem(STORAGE_KEY_LONGEST) || '0', 10);
            if (current > longest) longest = current;

            localStorage.setItem(STORAGE_KEY_STREAK, String(current));
            localStorage.setItem(STORAGE_KEY_LONGEST, String(longest));

            this.updateUI(TARGET_QUESTIONS, TARGET_QUESTIONS, current, longest, true);
            this.triggerCelebration(current, `🎉 অসাধারণ! আজকের পড়ার লক্ষ্য অর্জিত হয়েছে। বর্তমান স্ট্রিক: ${toBnNum(current)} দিন!`);
        },

        triggerCelebration: function (streakCount, customMsg) {
            const message = customMsg || `🎉 চমৎকার! আজকের ২০টি প্রশ্ন পড়ার টার্গেট পূর্ণ হয়েছে! বর্তমান স্ট্রিক: ${toBnNum(streakCount)} দিন 🔥`;
            window.showToast(message, 'success');

            // Fire pulse animation on streak button
            const btn = document.getElementById('header-streak-btn');
            if (btn) {
                btn.classList.add('ring-4', 'ring-amber-400', 'scale-110');
                setTimeout(() => {
                    btn.classList.remove('ring-4', 'ring-amber-400', 'scale-110');
                }, 1200);
            }
        },

        updateUI: function (count, target, currentStreak, longestStreak, isCompleted) {
            const countClamped = Math.min(count, target);
            const percentage = Math.min(100, Math.round((countClamped / target) * 100));

            // Header streak badge counter
            const headerCountEl = document.getElementById('header-streak-count');
            if (headerCountEl) {
                headerCountEl.innerText = toBnNum(currentStreak);
            }

            // Header icon flame glow if target reached today
            const headerIconEl = document.getElementById('header-streak-icon');
            if (headerIconEl) {
                if (isCompleted || countClamped >= target) {
                    headerIconEl.classList.add('scale-125');
                }
            }

            // Popover stats
            const popoverProgressEl = document.getElementById('streak-popover-progress');
            if (popoverProgressEl) {
                popoverProgressEl.innerText = `${toBnNum(countClamped)} / ${toBnNum(target)}টি`;
            }

            const popoverBarEl = document.getElementById('streak-popover-bar');
            if (popoverBarEl) {
                popoverBarEl.style.width = `${percentage}%`;
            }

            const popoverCurrentEl = document.getElementById('streak-popover-current');
            if (popoverCurrentEl) {
                popoverCurrentEl.innerText = `${toBnNum(currentStreak)} দিন`;
            }

            const popoverLongestEl = document.getElementById('streak-popover-longest');
            if (popoverLongestEl) {
                popoverLongestEl.innerText = `${toBnNum(longestStreak)} দিন`;
            }

            const popoverStatusEl = document.getElementById('streak-popover-status');
            if (popoverStatusEl) {
                if (isCompleted || countClamped >= target) {
                    popoverStatusEl.innerHTML = `<span class="text-emerald-600 dark:text-emerald-400 font-bold">✅ আজকের লক্ষ্য অর্জিত হয়েছে!</span>`;
                } else {
                    const remaining = target - countClamped;
                    popoverStatusEl.innerHTML = `<span class="text-amber-700 dark:text-amber-400">আর মাত্র <b>${toBnNum(remaining)}টি</b> প্রশ্ন পড়ুন</span>`;
                }
            }

            // Dashboard Widget (if present)
            const dashCountEl = document.getElementById('dash-streak-count');
            if (dashCountEl) {
                dashCountEl.innerText = `${toBnNum(currentStreak)} দিন`;
            }

            const dashLongestEl = document.getElementById('dash-streak-longest');
            if (dashLongestEl) {
                dashLongestEl.innerText = `${toBnNum(longestStreak)} দিন`;
            }

            const dashBarEl = document.getElementById('dash-streak-bar');
            if (dashBarEl) {
                dashBarEl.style.width = `${percentage}%`;
            }

            const dashProgressEl = document.getElementById('dash-streak-progress');
            if (dashProgressEl) {
                dashProgressEl.innerText = `${toBnNum(countClamped)} / ${toBnNum(target)}টি`;
            }

            const dashStatusBadge = document.getElementById('dash-streak-badge');
            if (dashStatusBadge) {
                if (isCompleted || countClamped >= target) {
                    dashStatusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 border border-emerald-300/80 dark:border-emerald-800';
                    dashStatusBadge.innerHTML = '<span>✅ আজকের লক্ষ্য অর্জিত</span>';
                } else {
                    const remaining = target - countClamped;
                    dashStatusBadge.className = 'inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-100 dark:bg-amber-950/70 text-amber-800 dark:text-amber-300 border border-amber-300/80 dark:border-amber-800';
                    dashStatusBadge.innerHTML = `<span>🎯 আর ${toBnNum(remaining)}টি বাকি</span>`;
                }
            }
        },

        startStudyTimer: function () {
            let activeSeconds = 0;
            setInterval(() => {
                if (!document.hidden) {
                    activeSeconds++;
                    if (activeSeconds >= 60 && this.isAuthenticated()) {
                        const secondsToSync = activeSeconds;
                        activeSeconds = 0;
                        this.syncStudySeconds(secondsToSync);
                    }
                }
            }, 1000);
        },

        syncStudySeconds: function (seconds) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) return;
            fetch('/api/user/study-stats/sync', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ add_seconds: seconds })
            }).catch(() => {});
        },

        init: function () {
            this.hydrateFromMeta();
            const state = this.getTodayState();
            this.updateUI(state.count, state.target, state.currentStreak, state.longestStreak, state.isCompletedToday);

            // If user is authenticated and completed target locally today but hasn't synced with server yet
            if (this.isAuthenticated() && state.count >= state.target && !state.synced && !state.isCompletedToday) {
                this.completeDailyTarget();
            }

            // Start active reading timer
            this.startStudyTimer();

            // Global click listener for questions/options
            document.addEventListener('click', (e) => {
                const optBtn = e.target.closest('.option-btn, .option-card, [data-option-label]');
                if (optBtn) {
                    const card = optBtn.closest('[data-question-id], .question-item, #question-showcase-card');
                    const qId = card?.dataset?.questionId;
                    if (qId) {
                        this.trackQuestion(qId);
                    }
                }
            });
        }
    };

    // Expose globally
    window.bdniyogStreak = StreakManager;

    // Auto-init on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => StreakManager.init());
    } else {
        StreakManager.init();
    }
})();

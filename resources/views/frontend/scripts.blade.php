<script>
    // Mobile Menu Drawer Logic
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-drawer-overlay');

        if (drawer.classList.contains('translate-x-full')) {
            drawer.classList.remove('translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
            document.body.classList.add('overflow-hidden');
        } else {
            drawer.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // ==========================================
    // PWA Install Logic (Turbo Drive Compatible)
    // ==========================================

    // গ্লোবাল ভেরিয়েবল সেট করা হলো, যেন Turbo পেজ চেঞ্জ করলেও ডাটা মুছে না যায়
    if (typeof window.deferredPrompt === 'undefined') {
        window.deferredPrompt = null;
    }

    // বাটন ভিজিবিলিটি কন্ট্রোল করার ফাংশন
    function updateInstallButton() {
        const btn = document.getElementById('installPwaBtn');
        if (btn) {
            if (window.deferredPrompt !== null) {
                btn.classList.remove('hidden'); // PWA রেডি থাকলে শো করবে
            } else {
                btn.classList.add('hidden'); // না থাকলে হাইড থাকবে
            }
        }
    }

    // ব্রাউজার যখন PWA ইন্সটল করার জন্য প্রস্তুত হয় (এটি সাধারণত একবারই ফায়ার হয়)
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        window.deferredPrompt = e;
        updateInstallButton(); // সাথে সাথে বাটন শো করাবে
    });

    // ইউজার যদি অ্যাপ ইন্সটল করে ফেলে
    window.addEventListener('appinstalled', () => {
        window.deferredPrompt = null;
        updateInstallButton();
        console.log('PWA was installed');
    });

    // Turbo Drive দিয়ে পেজ পরিবর্তন হলে নতুন বাটনের সাথে ক্লিক ইভেন্ট যুক্ত করতে হবে
    document.addEventListener('turbo:load', () => {
        updateInstallButton(); // নতুন পেজে বাটন আপডেট করবে

        const btn = document.getElementById('installPwaBtn');
        if (btn) {
            // ক্লিক ইভেন্ট যুক্ত করা
            btn.addEventListener('click', async () => {
                if (window.deferredPrompt !== null) {
                    window.deferredPrompt.prompt();
                    const { outcome } = await window.deferredPrompt.userChoice;

                    if (outcome === 'accepted') {
                        console.log('User installed the PWA');
                    }

                    window.deferredPrompt = null;
                    updateInstallButton(); // বাটন হাইড করে দেবে
                }
            });
        }
    });

    // ==========================================
    // Service Worker Registration
    // ==========================================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('ServiceWorker registration successful');
                })
                .catch(err => {
                    console.error('ServiceWorker registration failed: ', err);
                });
        });
    }
</script>

<script>
    // Mobile Menu Drawer Logic
    function toggleMobileMenu() {
        const drawer = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('mobile-drawer-overlay');

        if (drawer.classList.contains('translate-x-full')) {
            // Open Drawer
            drawer.classList.remove('translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
            document.body.classList.add('overflow-hidden');
        } else {
            // Close Drawer
            drawer.classList.add('translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Turbo Drive এর কনফ্লিক্ট এড়াতে var ব্যবহার করা হলো
    var deferredPrompt = null;
    var installBtn = document.getElementById('installPwaBtn');

    // ব্রাউজার যখন PWA ইন্সটল করার জন্য প্রস্তুত হয়, তখন এই ইভেন্ট কল হয়
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;

        // PWA সাপোর্টেড হলে বাটনটি দৃশ্যমান করুন (hidden ক্লাস সরিয়ে দিন)
        if (installBtn) {
            installBtn.classList.remove('hidden');
        }
    });

    // বাটনে ক্লিক করলে প্রম্পট দেখাবে
    if (installBtn) {
        installBtn.addEventListener('click', async () => {
            if (deferredPrompt !== null) {
                deferredPrompt.prompt(); // ইন্সটল প্রম্পট উইন্ডো ওপেন হবে

                const { outcome } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    console.log('User installed the PWA');
                } else {
                    console.log('User dismissed the install prompt');
                }

                // একবার প্রম্পট দেখালে এটি আর ব্যবহার করা যায় না
                deferredPrompt = null;
                installBtn.classList.add('hidden');
            }
        });
    }

    // ইউজার যদি নিজে থেকে অ্যাপ ইন্সটল করে ফেলে, তবে বাটনটি লুকিয়ে ফেলুন
    window.addEventListener('appinstalled', () => {
        deferredPrompt = null;
        if (installBtn) {
            installBtn.classList.add('hidden');
        }
        console.log('PWA was installed');
    });

    // ==========================================
    // Service Worker Registration
    // ==========================================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                })
                .catch(err => {
                    console.error('ServiceWorker registration failed: ', err);
                });
        });
    }
</script>

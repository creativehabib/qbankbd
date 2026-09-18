<script>
        // Theme toggle logic
    document.getElementById('theme-toggle').addEventListener('click', function() {
        var htmlClasses = document.documentElement.classList;
        if(htmlClasses.contains('dark')) {
            htmlClasses.remove('dark');
            localStorage.setItem('flux.appearance', 'light');
            localStorage.setItem('color-theme', 'light');
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
        } else {
            htmlClasses.add('dark');
            localStorage.setItem('flux.appearance', 'dark');
            localStorage.setItem('color-theme', 'dark');
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        }
    });

    // Initialize Theme icon state
    window.addEventListener('DOMContentLoaded', () => {
        if(document.documentElement.classList.contains('dark')) {
            document.getElementById('theme-toggle-dark-icon').classList.add('hidden');
            document.getElementById('theme-toggle-light-icon').classList.remove('hidden');
        } else {
            document.getElementById('theme-toggle-dark-icon').classList.remove('hidden');
            document.getElementById('theme-toggle-light-icon').classList.add('hidden');
        }
    });

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
</script>
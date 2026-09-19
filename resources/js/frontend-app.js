import * as Turbo from "@hotwired/turbo";
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import renderMathInElement from 'katex/dist/contrib/auto-render';
import katex from 'katex';
import 'katex/dist/katex.min.css';

// --- Alpine.js Setup ---
window.Alpine = Alpine;
Alpine.plugin(collapse);
Alpine.start();

// --- Turbo Drive Customization ---
document.addEventListener("turbo:load", function() {
    const progressBar = document.querySelector('.turbo-progress-bar');
    if (progressBar) {
        progressBar.style.backgroundColor = '#10b981'; // Emerald Color
    }
});

// --- MathJax/KaTeX Rendering Setup ---
window.renderKatex = function() {
    renderMathInElement(document.body, {
        delimiters: [
            {left: '$$', right: '$$', display: true},
            {left: '\\[', right: '\\]', display: true},
            {left: '$', right: '$', display: false},
            {left: '\\(', right: '\\)', display: false}
        ],
        throwOnError: false,
        ignoredTags: ["script", "noscript", "style", "textarea", "pre", "code", "div.ck-editor-container"]
    });

    // Fallback for old MathJax elements
    document.querySelectorAll('script[type="math/tex"]').forEach(el => {
        let tex = el.textContent || el.innerText;
        let span = document.createElement('span');
        try {
            katex.render(tex, span, { displayMode: false, throwOnError: false });
            el.replaceWith(span);
        } catch(e) {}
    });

    document.querySelectorAll('script[type="math/tex; mode=display"]').forEach(el => {
        let tex = el.textContent || el.innerText;
        let div = document.createElement('div');
        try {
            katex.render(tex, div, { displayMode: true, throwOnError: false });
            el.replaceWith(div);
        } catch(e) {}
    });

    document.body.classList.remove('math-loading');
};


// --- Initial load & Turbo render hooks (Flicker-Free) ---

// ১. ওয়েবসাইটের প্রথমবার লোড হওয়ার জন্য (First direct visit)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.renderKatex === 'function') window.renderKatex();
    });
} else {
    if (typeof window.renderKatex === 'function') window.renderKatex();
}

// ২. এক লিংক থেকে অন্য লিংকে যাওয়ার জন্য (Turbo Navigation)
document.addEventListener('turbo:render', () => {
    // turbo:render স্ক্রিনে পেজ দেখানোর ঠিক আগে কাজ করে, তাই কোনো ঝাঁকুনি হবে না
    if (typeof window.renderKatex === 'function') {
        window.renderKatex();
    }
});

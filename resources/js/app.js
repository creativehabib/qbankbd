import $ from 'jquery';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';
import TomSelect from 'tom-select';
import ApexCharts from 'apexcharts';
import { collapse } from "@alpinejs/collapse";
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

// Alpine & Plugins
Alpine.plugin(collapse);

// Global Window Objects
window.Swal = Swal;
window.Choices = Choices;
window.TomSelect = TomSelect;
window.ApexCharts = ApexCharts;
window.$ = window.jQuery = $;
window.toastr = toastr;

// Toastr ডিফল্ট অপশন
toastr.options = {
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": "3000",
};

// --- লাইভওয়্যার টোস্ট ইভেন্টস ---
window.addEventListener('success', event => toastr.success(event.detail.message));
window.addEventListener('warning', event => toastr.warning(event.detail.message));
window.addEventListener('error', event => toastr.error(event.detail.message));

let mathJaxRenderTimer;

window.whenCkEditorReady = function (callback) {
    if (window.CKEDITOR) {
        callback();

        return;
    }

    window.setTimeout(() => window.whenCkEditorReady(callback), 50);
};

window.renderMathJax = function (elements = undefined) {
    clearTimeout(mathJaxRenderTimer);

    mathJaxRenderTimer = window.setTimeout(() => {
        if (! window.MathJax?.typesetPromise) {
            return;
        }

        const targets = elements instanceof Element ? [elements] : elements;

        window.MathJax.typesetClear?.(targets);
        window.MathJax.typesetPromise(targets)
            .catch((error) => console.warn('MathJax rendering failed:', error));
    }, 100);
};

document.addEventListener('livewire:navigated', () => window.renderMathJax());
window.addEventListener('practice-content-updated', () => window.renderMathJax());
window.addEventListener('load', () => window.renderMathJax());

new MutationObserver((mutations) => {
    if (mutations.some((mutation) => [...mutation.addedNodes].some((node) => ! node.classList?.contains('MathJax')))) {
        window.renderMathJax();
    }
}).observe(document.body, { childList: true, subtree: true });

// --- Flux UI delete confirmation ---
window.confirmDeleteAction = function (callback) {
    window.pendingDeleteAction = callback;
    window.Flux?.modal('delete-confirmation').show();
};

window.confirmPendingDeletion = function () {
    const callback = window.pendingDeleteAction;

    window.pendingDeleteAction = null;
    window.Flux?.modal('delete-confirmation').close();

    if (typeof callback === 'function') {
        callback();
    }
};

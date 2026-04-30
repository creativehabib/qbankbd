import $ from 'jquery';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import Swal from 'sweetalert2';
import TomSelect from 'tom-select';
import ApexCharts from 'apexcharts';
import {collapse} from "@alpinejs/collapse";
import Choices from 'choices.js';
import 'choices.js/public/assets/styles/choices.min.css';

Alpine.plugin(collapse)
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

// লাইভওয়্যার ইভেন্ট লিসেনার
window.addEventListener('success', event => {
    toastr.success(event.detail.message);
});

window.addEventListener('warning', event => {
    toastr.warning(event.detail.message);
});

window.addEventListener('error', event => {
    toastr.error(event.detail.message);
});

window.renderMathJax = function (root = document) {
    if (!window.MathJax?.typesetPromise) {
        return;
    }

    const scope = root instanceof Element || root instanceof Document ? root : document;
    const mathElements = scope.querySelectorAll('[data-math-content]');

    if (mathElements.length > 0) {
        window.MathJax.typesetPromise(Array.from(mathElements));

        return;
    }

    window.MathJax.typesetPromise();
};

document.addEventListener('DOMContentLoaded', () => {
    window.renderMathJax();
});

document.addEventListener('livewire:navigated', () => {
    window.renderMathJax();
});

window.addEventListener('practice-content-updated', () => {
    window.renderMathJax();
});


window.confirmDeleteAction = async function (callback, options = {}) {
    const isDarkMode = document.documentElement.classList.contains('dark')
        || window.matchMedia('(prefers-color-scheme: dark)').matches;

    if (!window.Swal) {
        if (typeof callback === 'function') {
            callback();
        }

        return;
    }

    const result = await Swal.fire({
        title: options.title ?? 'Are you sure?',
        text: options.text ?? 'You will not be able to recover this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: options.confirmButtonColor ?? '#ef4444',
        cancelButtonColor: options.cancelButtonColor ?? '#6b7280',
        confirmButtonText: options.confirmButtonText ?? 'Yes, delete it!',
        cancelButtonText: options.cancelButtonText ?? 'Cancel',
        reverseButtons: options.reverseButtons ?? true,
        background: options.background ?? (isDarkMode ? '#1f2937' : '#ffffff'),
        color: options.color ?? (isDarkMode ? '#f3f4f6' : '#111827'),
        customClass: options.customClass,
    });

    if (result.isConfirmed && typeof callback === 'function') {
        callback();
    }
};

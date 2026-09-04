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

// --- MathJax রেন্ডারিং লজিক (একীভূত করা হয়েছে) ---
window.renderMathJax = function () {
    if (window.MathJax && window.MathJax.typesetPromise) {
        // ছোট ডিলে দেওয়া হয়েছে যাতে ডোম (DOM) আপডেট হওয়ার পর্যাপ্ত সময় পায়
        setTimeout(() => {
            window.MathJax.typesetPromise()
                .catch((err) => console.warn('MathJax error:', err));
        }, 100);
    }
};

// MathJax এর জন্য ইভেন্ট লিসেনারসমূহ
document.addEventListener('livewire:navigated', window.renderMathJax);
window.addEventListener('practice-content-updated', window.renderMathJax);

// সরাসরি বাটন (যেমন: Explanation) ক্লিক করলে রেন্ডার করার জন্য
document.addEventListener('click', (e) => {
    if (e.target.closest('button')) {
        setTimeout(window.renderMathJax, 400);
    }
});

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

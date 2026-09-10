import $ from 'jquery';
import TomSelect from 'tom-select';
import ApexCharts from 'apexcharts';
import { collapse } from "@alpinejs/collapse";

// Alpine & Plugins
Alpine.plugin(collapse);

// Global Window Objects
window.TomSelect = TomSelect;
window.ApexCharts = ApexCharts;
window.$ = window.jQuery = $;

// --- লাইভওয়্যার টোস্ট ইভেন্টস ---
window.addEventListener('success', event => {
    let msg = event.detail.message || (event.detail[0] && event.detail[0].message);
    if (msg && window.Flux) window.Flux.toast({ text: msg, variant: 'success' });
});
window.addEventListener('warning', event => {
    let msg = event.detail.message || (event.detail[0] && event.detail[0].message);
    if (msg && window.Flux) window.Flux.toast({ text: msg, variant: 'warning' });
});
window.addEventListener('error', event => {
    let msg = event.detail.message || (event.detail[0] && event.detail[0].message);
    if (msg && window.Flux) window.Flux.toast({ text: msg, variant: 'danger' });
});

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

// --- Global CKEditor & MathJax Helpers ---
window.wrapMathForCKEditor = function(html) {
    if (!html || typeof html !== 'string') return html;
    let cleanHtml = html.replace(/<span class="math-tex">([\s\S]*?)<\/span>/g, '$1');
    
    // Convert $...$ to \(...\)
    cleanHtml = cleanHtml.replace(/(^|[^\\])\$([^\$]+?)\$/g, '$1\\($2\\)');
    
    cleanHtml = cleanHtml.replace(/\\\(([\s\S]*?)\\\)/g, '<span class="math-tex">\\($1\\)</span>');
    cleanHtml = cleanHtml.replace(/\\\[([\s\S]*?)\\\]/g, '<span class="math-tex">\\[$1\\]</span>');
    return cleanHtml;
};

window.initGlobalCkEditor = function(elementId, livewireComponent, livewireProperty, isAdvanced = false) {
    const el = document.getElementById(elementId);
    if (!el || el.offsetParent === null) return null;

    if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances[elementId]) {
        try { CKEDITOR.instances[elementId].destroy(true); } catch(e) {}
    }

    let toolbarConfig = [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Subscript', 'Superscript'] },
        { name: 'insert', items: ['SpecialCharacter', 'Mathjax'] },
        { name: 'colors', items: ['TextColor', 'BGColor'] },
        { name: 'document', items: ['Source'] }
    ];

    if (isAdvanced) {
        toolbarConfig = [
            { name: 'clipboard', items: ['Undo', 'Redo'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialCharacter', 'Mathjax'] },
            { name: 'colors', items: ['TextColor', 'BGColor'] },
            { name: 'tools', items: ['Maximize'] },
            { name: 'document', items: ['Source'] }
        ];
    }

    const editor = CKEDITOR.replace(elementId, {
        extraPlugins: 'mathjax,tableresize,wordcount,notification,justify,font,colorbutton',
        mathJaxLib: '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.4/MathJax.js?config=TeX-AMS_HTML',
        toolbar: toolbarConfig,
        height: isAdvanced ? 180 : 120,
        allowedContent: true,
        uiColor: document.documentElement.classList.contains('dark') ? '#2d3748' : '#f9fafb'
    });

    editor.on('instanceReady', function() {
        let currentData = editor.getData();
        let formattedData = window.wrapMathForCKEditor(currentData);
        if (currentData !== formattedData) {
            editor.setData(formattedData);
        }
    });

    editor.on('paste', function(evt) {
        evt.data.dataValue = window.wrapMathForCKEditor(evt.data.dataValue);
    });

    if (livewireProperty && livewireComponent) {
        let ckDebounceTimer;
        editor.on('change', function () {
            let data = editor.getData();
            clearTimeout(ckDebounceTimer);
            ckDebounceTimer = setTimeout(() => {
                livewireComponent.$set(livewireProperty, data);
                if (livewireProperty === 'title') {
                    let isEditMode = window.location.href.includes('/edit');
                    let slugInput = document.getElementById('slug_input');
                    if (slugInput) {
                        let isManualEdited = slugInput.getAttribute('data-manual') === 'true';
                        if (!isEditMode && !isManualEdited) {
                            let div = document.createElement("div");
                            div.innerHTML = data;
                            let plainText = div.innerText || div.textContent || "";
                            let newSlug = plainText.trim().toLowerCase().replace(/[^\w\u0980-\u09FF\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').replace(/^-+|-+$/g, '').substring(0, 100);
                            window.dispatchEvent(new CustomEvent('slug-auto-updated', { detail: newSlug }));
                        }
                    }
                }
            }, 500);
        });
    }

    return editor;
};

// Global cleanup for CKEditor to avoid memory leaks or duplicate instances on Livewire navigation
document.addEventListener('livewire:navigating', () => {
    if (typeof CKEDITOR !== 'undefined') {
        for (let instanceName in CKEDITOR.instances) {
            try { CKEDITOR.instances[instanceName].destroy(true); } catch(e) {}
        }
    }
});

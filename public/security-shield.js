/**
 * Qerobi.com Security Shield
 * Protects site content, assets, and tools from unauthorized copying, scraping, and inspection.
 */
(function () {
    'use strict';

    const config = window.__SECURITY_CONFIG__ || {
        disableRightClick: false,
        disableTextCopy: false,
        disableInspect: false,
        isAdmin: false
    };

    // If current session is an authenticated Administrator, do not enforce restrictions
    if (config.isAdmin) {
        return;
    }

    // Helper: Check if an element is an input, textarea, or editable element
    function isInputElement(el) {
        if (!el) return false;
        const tag = el.tagName ? el.tagName.toUpperCase() : '';
        if (tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT') {
            return true;
        }
        if (el.isContentEditable || el.getAttribute('contenteditable') === 'true') {
            return true;
        }
        if (el.closest && el.closest('[contenteditable="true"], input, textarea, .allow-select, .selectable')) {
            return true;
        }
        return false;
    }

    // 1. Right-Click Context Menu Protection
    // Blocked if disableRightClick is ON, or if disableInspect is ON (to prevent right-click "Inspect")
    if (config.disableRightClick || config.disableInspect) {
        document.addEventListener('contextmenu', function (e) {
            if (!isInputElement(e.target)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        }, true);
    }

    // 2. Disable Copy, Cut & Drag outside inputs (Only when disableTextCopy is active)
    if (config.disableTextCopy) {
        document.addEventListener('copy', function (e) {
            if (!isInputElement(e.target)) {
                e.preventDefault();
                return false;
            }
        }, true);

        document.addEventListener('cut', function (e) {
            if (!isInputElement(e.target)) {
                e.preventDefault();
                return false;
            }
        }, true);

        document.addEventListener('dragstart', function (e) {
            if (!isInputElement(e.target)) {
                e.preventDefault();
                return false;
            }
        }, true);

        // Disable Ctrl+A and Ctrl+C outside inputs
        document.addEventListener('keydown', function (e) {
            const key = e.key ? e.key.toUpperCase() : '';
            const keyCode = e.keyCode || e.which;
            const isCtrl = e.ctrlKey || e.metaKey;

            if (isCtrl && !isInputElement(e.target)) {
                if (key === 'A' || keyCode === 65 || key === 'C' || keyCode === 67) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }
            }
        }, true);
    }

    // 3. Inspect & DevTools Code Protection (Only when disableInspect is active)
    if (config.disableInspect) {
        // Block Inspect Keyboard Shortcuts (F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C, Ctrl+Shift+K, Ctrl+U, Ctrl+S)
        function blockInspectKeys(e) {
            const key = e.key ? e.key.toUpperCase() : '';
            const keyCode = e.keyCode || e.which;
            const isCtrl = e.ctrlKey || e.metaKey;
            const isShift = e.shiftKey;
            const isAlt = e.altKey;

            // F12 key
            if (key === 'F12' || keyCode === 123) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            // Ctrl+Shift+I (Inspect), Ctrl+Shift+J (Console), Ctrl+Shift+C (Element picker), Ctrl+Shift+K (Firefox console)
            if (isCtrl && isShift && (key === 'I' || keyCode === 73 || key === 'J' || keyCode === 74 || key === 'C' || keyCode === 67 || key === 'K' || keyCode === 75)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            // Ctrl+U (View Source), Ctrl+S (Save Page)
            if (isCtrl && (key === 'U' || keyCode === 85 || key === 'S' || keyCode === 83)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }

            // Mac equivalents: Cmd+Option+I, Cmd+Option+J, Cmd+Option+C, Cmd+Option+U
            if (e.metaKey && isAlt && (key === 'I' || keyCode === 73 || key === 'J' || keyCode === 74 || key === 'C' || keyCode === 67 || key === 'U' || keyCode === 85)) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        }

        document.addEventListener('keydown', blockInspectKeys, true);
        window.addEventListener('keydown', blockInspectKeys, true);

        // Silence Console output methods
        try {
            const noop = function () {};
            window.console.log = noop;
            window.console.info = noop;
            window.console.warn = noop;
            window.console.error = noop;
            window.console.debug = noop;
            window.console.table = noop;
            window.console.dir = noop;
        } catch (_) {}

        // Anti-DevTools debugger loop to freeze unauthorized inspection
        let devToolsOpen = false;
        let debuggerInterval = null;

        function triggerDebugger() {
            try {
                (function () {
                    return false;
                }['constructor']('debugger')['call']());
            } catch (_) {}
        }

        function detectDevTools() {
            const widthDiff = window.outerWidth - window.innerWidth;
            const heightDiff = window.outerHeight - window.innerHeight;
            const isOpen = (widthDiff > 160 || heightDiff > 160);

            if (isOpen) {
                if (!devToolsOpen) {
                    devToolsOpen = true;
                    triggerDebugger();
                    if (!debuggerInterval) {
                        debuggerInterval = setInterval(triggerDebugger, 500);
                    }
                }
            } else {
                if (devToolsOpen) {
                    devToolsOpen = false;
                    if (debuggerInterval) {
                        clearInterval(debuggerInterval);
                        debuggerInterval = null;
                    }
                }
            }
        }

        window.addEventListener('resize', detectDevTools);
        setInterval(detectDevTools, 1500);
        detectDevTools();
    }
})();

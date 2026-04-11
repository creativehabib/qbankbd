import Swal from 'sweetalert2';
import TomSelect from 'tom-select';
import ApexCharts from 'apexcharts';

window.Swal = Swal;
window.TomSelect = TomSelect;
window.ApexCharts = ApexCharts;


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

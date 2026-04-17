<div class="space-y-6">
    <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Theme Options</h2>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Typography settings are stored in settings table and applied globally.</p>
    </div>

    <form wire:submit.prevent="saveTypography" class="space-y-6 rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <div class="space-y-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Primary Font') }}</label>
                <input id="primary-font-value" type="hidden" wire:model="primary_font">
                <div wire:ignore>
                    <select id="primary-font-select" class="w-full">
                        <option value="">{{ __('Select font') }}</option>
                        @foreach($googleFonts as $font)
                            <option value="{{ $font['family'] }}" @selected($primary_font === $font['family'])>{{ $font['family'] }}</option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-xs text-slate-500">{{ __('Choose a Google font for the frontend typography.') }}</p>
                @error('primary_font') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Font Weights') }}</label>
                <input wire:model="primary_font_weights" type="text" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-slate-900 outline-none dark:border-slate-600 dark:bg-slate-800 dark:text-white" placeholder="300;400;500;600;700">
                <p class="mt-1 text-xs text-slate-500">{{ __('Use semicolons between weights, e.g. 300;400;500;600;700.') }}</p>
                @error('primary_font_weights') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">{{ __('Body Font Size') }}</label>
                <select wire:model="body_font_size" class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-slate-900 outline-none dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                    @foreach(['14px', '15px', '16px', '17px', '18px', '20px'] as $size)
                        <option value="{{ $size }}">{{ $size }}</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-slate-500">{{ __('Set the default font size for frontend body text.') }}</p>
                @error('body_font_size') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="inline-flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300">
                    <input type="checkbox" wire:model="autoload" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-600" />
                    {{ __('Autoload in runtime') }}
                </label>
            </div>
        </div>

        <div class="flex justify-end border-t border-slate-200 pt-6 dark:border-slate-700">
            <button type="submit"
                    wire:loading.attr="disabled"
                    wire:target="saveTypography"
                    class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-6 py-2 font-medium text-white shadow-sm transition-all hover:bg-indigo-700 disabled:cursor-not-allowed disabled:bg-indigo-400">
                <span wire:loading.remove wire:target="saveTypography">{{ __('Save Changes') }}</span>
                <span wire:loading wire:target="saveTypography">{{ __('Saving...') }}</span>
            </button>
        </div>
    </form>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const initPrimaryFontChoices = () => {
            const select = document.getElementById('primary-font-select');
            const hiddenInput = document.getElementById('primary-font-value');

            if (!select || !hiddenInput || select.dataset.choicesInitialized === 'true' || !window.Choices) {
                return;
            }

            new window.Choices(select, {
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: '',
                allowHTML: false,
                renderChoiceLimit: -1,
                searchResultLimit: 2000,
            });

            select.dataset.choicesInitialized = 'true';

            select.addEventListener('change', () => {
                hiddenInput.value = select.value;
                hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            });
        };

        document.addEventListener('DOMContentLoaded', initPrimaryFontChoices);
        document.addEventListener('livewire:navigated', initPrimaryFontChoices);

        window.addEventListener('theme-options-saved', (event) => {
            if (!window.Swal) {
                return;
            }

            window.Swal.fire({
                toast: true,
                icon: 'success',
                title: event.detail.message || 'Saved',
                position: 'top-end',
                timer: 1500,
                showConfirmButton: false,
            });
        });
    </script>
</div>

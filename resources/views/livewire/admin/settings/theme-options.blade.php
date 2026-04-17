<div>
    <div class="space-y-6">
        <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Theme Options</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Typography settings are stored as JSON in the <code>settings</code> table by group.</p>
        </div>

        <form wire:submit="save" class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-6 grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="primary_font" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Primary Font</label>
                    <div wire:ignore>
                        <select id="primary_font" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100">
                            <option value="">Select font</option>
                            <option value="{{ $primaryFont }}" selected>{{ $primaryFont }}</option>
                        </select>
                    </div>
                    @error('primaryFont') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="font_weights" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Font Weights</label>
                    <input id="font_weights" type="text" wire:model="fontWeights" placeholder="300;400;500;600;700" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100" />
                    @error('fontWeights') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="body_font_size" class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Body Font Size</label>
                    <select id="body_font_size" wire:model="bodyFontSize" class="w-full rounded-md border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-zinc-100">
                        <option value="14px">14px</option>
                        <option value="15px">15px</option>
                        <option value="16px">16px</option>
                        <option value="17px">17px</option>
                        <option value="18px">18px</option>
                    </select>
                    @error('bodyFontSize') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2 text-sm text-zinc-700 dark:text-zinc-300">
                        <input type="checkbox" wire:model="autoload" class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-600" />
                        Autoload in runtime
                    </label>
                    @error('autoload') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700">Save Settings</button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        const FONT_JSON_URL = @js(route('admin.theme-options.fonts'));

        function normalizeFontPayload(payload) {
            const rawFonts = Array.isArray(payload)
                ? payload
                : Array.isArray(payload?.fonts)
                    ? payload.fonts
                    : Array.isArray(payload?.items)
                        ? payload.items
                        : typeof payload === 'object' && payload !== null
                            ? Object.entries(payload).map(([family, value]) => ({ family, ...value }))
                            : [];

            const mappedFonts = rawFonts.map((font) => ({
                family: String(font.family ?? font.name ?? '').trim(),
                variants: Array.isArray(font.variants)
                    ? font.variants
                    : Array.isArray(font.weights)
                        ? font.weights
                        : [],
            })).filter((font) => font.family !== '');

            const seen = new Set();

            return mappedFonts.filter((font) => {
                if (seen.has(font.family)) {
                    return false;
                }

                seen.add(font.family);

                return true;
            });
        }

        function normalizeWeightVariants(variants) {
            return (variants ?? [])
                .map((variant) => String(variant))
                .map((variant) => variant === 'regular' ? '400' : variant)
                .map((variant) => variant === 'italic' ? '400' : variant)
                .map((variant) => variant.replace('italic', ''))
                .filter((variant) => /^[1-9]00$/.test(variant));
        }

        function bootThemeFontChoices() {
            const select = document.getElementById('primary_font');
            const weightInput = document.getElementById('font_weights');

            if (!select || typeof window.Choices === 'undefined') {
                return;
            }

            if (select.dataset.choicesInitialized === 'true') {
                return;
            }

            select.dataset.choicesInitialized = 'true';

            const choices = new window.Choices(select, {
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: 'Select font',
                duplicateItemsAllowed: false,
                addItems: true,
                addChoices: true,
                renderChoiceLimit: -1,
                searchResultLimit: 2000,
            });

            fetch(FONT_JSON_URL)
                .then((response) => response.json())
                .then((fontsPayload) => {
                    const fonts = normalizeFontPayload(fontsPayload);
                    const fontMap = new Map(fonts.map((font) => [font.family, font]));
                    select.dataset.fontMap = JSON.stringify(Object.fromEntries(fontMap));

                    if (fonts.length === 0) {
                        return;
                    }

                    const values = fonts.map((font) => ({
                        value: font.family,
                        label: font.family,
                        selected: font.family === @js($primaryFont),
                    }));

                    choices.setChoices(values, 'value', 'label', true);
                })
                .catch(() => {});

            select.addEventListener('change', (event) => {
                const selectedFont = event.target.value;
                window.Livewire.dispatch('theme-font-selected', { font: selectedFont });

                try {
                    const fontMap = JSON.parse(select.dataset.fontMap ?? '{}');
                    const variants = normalizeWeightVariants(fontMap[selectedFont]?.variants ?? []);

                    if (variants.length > 0 && weightInput) {
                        const joinedWeights = [...new Set(variants)].join(';');
                        weightInput.value = joinedWeights;
                        weightInput.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                } catch {}
            });
        }

        document.addEventListener('DOMContentLoaded', bootThemeFontChoices);
        document.addEventListener('livewire:navigated', bootThemeFontChoices);

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

<?php

namespace App\Livewire\Admin\Settings;

use App\Support\SettingsStore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ThemeOptions extends Component
{
    public string $primary_font = 'Nunito';

    public string $primary_font_weights = '300;400;500;600;700';

    public string $body_font_size = '16px';

    public bool $autoload = true;

    /**
     * @var array<int, array{family: string, variants: array<int, string>}>
     */
    public array $google_fonts = [];

    public function mount(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $settings = SettingsStore::group('typography');

        $this->primary_font = (string) ($settings['primary_font'] ?? $this->primary_font);
        $this->primary_font_weights = (string) ($settings['primary_font_weights'] ?? $this->primary_font_weights);
        $this->body_font_size = (string) ($settings['body_font_size'] ?? $this->body_font_size);
        $this->autoload = (bool) ($settings['autoload'] ?? $this->autoload);
        $this->google_fonts = $this->loadGoogleFonts();
    }

    public function saveTypography(): void
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        $validated = $this->validate([
            'primary_font' => ['required', 'string', 'max:255'],
            'primary_font_weights' => ['nullable', 'string', 'max:255'],
            'body_font_size' => ['required', 'string', Rule::in(['14px', '15px', '16px', '17px', '18px', '20px'])],
            'autoload' => ['required', 'boolean'],
        ]);

        SettingsStore::saveGroup('typography', [
            'primary_font' => trim($validated['primary_font']),
            'primary_font_weights' => trim($validated['primary_font_weights']),
            'body_font_size' => trim($validated['body_font_size']),
            'autoload' => $validated['autoload'] ? '1' : '0',
        ], $validated['autoload']);

        $this->dispatch('theme-options-saved', message: 'Typography settings updated successfully!');
    }

    public function save(): void
    {
        $this->saveTypography();
    }

    public function updatedPrimaryFont(string $value): void
    {
        $fontFamily = trim($value);
        $matchedFont = collect($this->google_fonts)->firstWhere('family', $fontFamily);

        if (! $matchedFont) {
            return;
        }

        $variants = $matchedFont['variants'] ?? [];
        $weights = collect($variants)
            ->map(fn (string $variant): string => $variant === 'regular' ? '400' : str_replace('italic', '', $variant))
            ->filter(fn (string $variant): bool => preg_match('/^[1-9]00$/', $variant) === 1)
            ->unique()
            ->values()
            ->all();

        if ($weights !== []) {
            $this->primary_font_weights = implode(';', $weights);
        }
    }

    /**
     * @return array<int, array{family: string, variants: array<int, string>}>
     */
    protected function loadGoogleFonts(): array
    {
        $payload = Cache::remember('theme-options-fonts-payload', now()->addHours(12), function (): array {
            $response = Http::timeout(20)->get('https://cdn.jsdelivr.net/gh/hasinhayder/google-fonts/fonts.json');

            return $response->successful() ? (array) $response->json() : [];
        });

        $rawFonts = [];

        if (array_is_list($payload)) {
            $rawFonts = $payload;
        } elseif (isset($payload['fonts']) && is_array($payload['fonts'])) {
            $rawFonts = $payload['fonts'];
        } elseif (isset($payload['items']) && is_array($payload['items'])) {
            $rawFonts = $payload['items'];
        } else {
            foreach ($payload as $family => $meta) {
                if (is_string($family)) {
                    $rawFonts[] = [
                        'family' => $family,
                        'variants' => is_array($meta['variants'] ?? null) ? $meta['variants'] : [],
                    ];
                }
            }
        }

        return collect($rawFonts)
            ->map(function ($font): array {
                if (is_string($font)) {
                    return ['family' => $font, 'variants' => []];
                }

                return [
                    'family' => trim((string) ($font['family'] ?? $font['name'] ?? '')),
                    'variants' => is_array($font['variants'] ?? null)
                        ? array_map('strval', $font['variants'])
                        : (is_array($font['weights'] ?? null) ? array_map('strval', $font['weights']) : []),
                ];
            })
            ->filter(fn (array $font): bool => $font['family'] !== '')
            ->unique('family')
            ->values()
            ->all();
    }

    public function render()
    {
        abort_unless(auth()->user()?->hasPermission('users.manage_roles'), 403);

        return view('livewire.admin.settings.theme-options', [
            'googleFonts' => $this->google_fonts,
        ])->layout('layouts.app', ['title' => 'Theme Options']);
    }
}

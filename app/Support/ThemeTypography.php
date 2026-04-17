<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

class ThemeTypography
{
    /**
     * @return array{font_family: string, css_font_family: string, body_font_size: string, google_fonts_url: string}
     */
    public static function current(): array
    {
        $defaults = [
            'font_family' => 'Instrument Sans',
            'font_weights' => '400;500;600',
            'body_font_size' => '16px',
        ];

        if (! Schema::hasTable('settings')) {
            return static::withDerivedValues($defaults);
        }

        $settings = SettingsStore::group('typography');

        if (! isset($settings['theme_options']) || ! is_array($settings['theme_options'])) {
            return static::withDerivedValues($defaults);
        }

        $themeOptions = $settings['theme_options'];

        $fontFamily = static::sanitizeFontFamily((string) ($themeOptions['primary_font'] ?? $defaults['font_family']));
        $fontWeights = static::sanitizeWeights((string) ($themeOptions['font_weights'] ?? $defaults['font_weights']));
        $bodyFontSize = static::sanitizeBodyFontSize((string) ($themeOptions['body_font_size'] ?? $defaults['body_font_size']));

        return static::withDerivedValues([
            'font_family' => $fontFamily,
            'font_weights' => $fontWeights,
            'body_font_size' => $bodyFontSize,
        ]);
    }

    /**
     * @param array{font_family: string, font_weights: string, body_font_size: string} $settings
     * @return array{font_family: string, css_font_family: string, body_font_size: string, google_fonts_url: string}
     */
    private static function withDerivedValues(array $settings): array
    {
        $encodedFamily = str_replace('%20', '+', rawurlencode($settings['font_family']));
        $googleFontsUrl = sprintf(
            'https://fonts.googleapis.com/css2?family=%s:wght@%s&display=swap',
            $encodedFamily,
            $settings['font_weights']
        );

        return [
            'font_family' => $settings['font_family'],
            'css_font_family' => sprintf("'%s', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'", addslashes($settings['font_family'])),
            'body_font_size' => $settings['body_font_size'],
            'google_fonts_url' => $googleFontsUrl,
        ];
    }

    private static function sanitizeFontFamily(string $fontFamily): string
    {
        $fontFamily = trim($fontFamily);

        if ($fontFamily === '') {
            return 'Instrument Sans';
        }

        if (preg_match('/^[\pL\pN\s\-]+$/u', $fontFamily) !== 1) {
            return 'Instrument Sans';
        }

        return $fontFamily;
    }

    private static function sanitizeWeights(string $weights): string
    {
        $parts = preg_split('/[\s,;]+/', $weights) ?: [];

        $allowed = collect($parts)
            ->filter(fn (string $weight): bool => preg_match('/^[1-9]00$/', $weight) === 1)
            ->unique()
            ->values()
            ->all();

        if ($allowed === []) {
            return '400;500;600';
        }

        return implode(';', $allowed);
    }

    private static function sanitizeBodyFontSize(string $fontSize): string
    {
        return in_array($fontSize, ['14px', '15px', '16px', '17px', '18px'], true)
            ? $fontSize
            : '16px';
    }
}

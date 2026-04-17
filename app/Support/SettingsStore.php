<?php

namespace App\Support;

use App\Models\Setting;

class SettingsStore
{
    /**
     * @return array<string, mixed>
     */
    public static function group(string $group): array
    {
        return Setting::query()
            ->forGroup($group)
            ->orderBy('key')
            ->get()
            ->mapWithKeys(function (Setting $setting): array {
                return [$setting->key => static::decodeValue($setting->value)];
            })
            ->all();
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function saveGroup(string $group, array $values, bool $autoload = true): void
    {
        foreach ($values as $key => $value) {
            Setting::query()->updateOrCreate(
                [
                    'key' => $key,
                    'group' => $group,
                ],
                [
                    'value' => static::encodeValue($value),
                    'autoload' => $autoload,
                ]
            );
        }
    }

    private static function encodeValue(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        }

        return (string) $value;
    }

    private static function decodeValue(?string $value): mixed
    {
        if ($value === null) {
            return null;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        return $value;
    }
}

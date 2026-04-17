<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null, string $group = 'typography'): mixed
    {
        static $cache = [];

        if (! Schema::hasTable('settings')) {
            return $default;
        }

        $cacheKey = $group.'|'.$key;

        if (! array_key_exists($cacheKey, $cache)) {
            $cache[$cacheKey] = Setting::query()
                ->where('group', $group)
                ->where('key', $key)
                ->value('value');
        }

        return $cache[$cacheKey] ?? $default;
    }
}

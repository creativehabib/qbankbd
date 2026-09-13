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

if (! function_exists('log_activity')) {
    /**
     * Log a user activity
     *
     * @param string $action The action performed (e.g., 'created_user', 'deleted_post')
     * @param string|null $description Optional detailed description
     * @param int|null $userId User ID, defaults to currently authenticated user
     * @return \App\Models\ActivityLog|null
     */
    function log_activity(string $action, ?string $description = null, ?int $userId = null)
    {
        try {
            if (!Schema::hasTable('activity_logs')) {
                return null;
            }

            return \App\Models\ActivityLog::create([
                'user_id' => $userId ?? auth()->id(),
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            return null; // Fail silently so it doesn't break app flow
        }
    }
}


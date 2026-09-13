<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            $name = $model->name ?? $model->title ?? $model->id;
            $type = class_basename($model);
            log_activity('created_' . strtolower($type), "Created {$type}: {$name}");
        });

        static::updated(function (Model $model) {
            $name = $model->name ?? $model->title ?? $model->id;
            $type = class_basename($model);
            log_activity('updated_' . strtolower($type), "Updated {$type}: {$name}");
        });

        static::deleted(function (Model $model) {
            $name = $model->name ?? $model->title ?? $model->id;
            $type = class_basename($model);
            log_activity('deleted_' . strtolower($type), "Deleted {$type}: {$name}");
        });
    }
}

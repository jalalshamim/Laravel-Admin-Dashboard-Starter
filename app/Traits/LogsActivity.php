<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            self::logActivity('created', $model);
        });

        static::updated(function (Model $model) {
            self::logActivity('updated', $model);
        });

        static::deleted(function (Model $model) {
            self::logActivity('deleted', $model);
        });
    }

    protected static function logActivity(string $action, Model $model)
    {
        $user = Auth::guard('admin')->user() ?? Auth::user();
        
        if (!$user) {
            return;
        }

        \App\Models\Activity::create([
            'user_id' => $user->id,
            'user_type' => get_class($user),
            'subject_id' => $model->id,
            'subject_type' => get_class($model),
            'action' => $action,
            'description' => ucfirst($action) . ' ' . class_basename($model) . ' #' . $model->id,
            'properties' => json_encode([
                'old' => $model->getOriginal(),
                'attributes' => $model->getAttributes(),
            ]),
        ]);
    }
} 
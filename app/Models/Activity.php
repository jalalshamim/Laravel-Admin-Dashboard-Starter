<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'subject_id',
        'subject_type',
        'action',
        'description',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the user that performed the activity.
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the subject of the activity.
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get recent activities
     */
    public static function getRecent($limit = 10)
    {
        return static::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
} 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get all menu items for this menu
     */
    public function items()
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('order');
    }

    /**
     * Get all menu items including nested ones
     */
    public function allItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    /**
     * Get cached menu items
     */
    public function getCachedItems()
    {
        $cacheKey = "menu_{$this->id}_items";
        
        return Cache::remember($cacheKey, now()->addHours(24), function () {
            return $this->items()->with('children')->get();
        });
    }

    /**
     * Clear menu cache
     */
    public function clearCache()
    {
        Cache::forget("menu_{$this->id}_items");
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($menu) {
            $menu->clearCache();
        });

        static::deleted(function ($menu) {
            $menu->clearCache();
        });
    }
}

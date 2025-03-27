<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'url',
        'icon',
        'target',
        'order',
        'depth',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the menu that owns the item
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    /**
     * Get the parent menu item
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Get the children menu items
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->orderBy('order')
            ->with('children');
    }

    /**
     * Check if item has reached maximum depth
     */
    public function hasReachedMaxDepth()
    {
        return $this->depth >= 3;
    }

    /**
     * Scope active items
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($menuItem) {
            // Update depth based on parent
            if ($menuItem->parent_id) {
                $parent = MenuItem::find($menuItem->parent_id);
                $menuItem->depth = $parent ? $parent->depth + 1 : 0;
            } else {
                $menuItem->depth = 0;
            }

            // Ensure depth doesn't exceed maximum
            if ($menuItem->depth > 3) {
                throw new \Exception('Maximum menu depth of 3 levels exceeded.');
            }
        });

        static::saved(function ($menuItem) {
            // Clear menu cache when item is saved
            if ($menuItem->menu) {
                $menuItem->menu->clearCache();
            }
        });

        static::deleted(function ($menuItem) {
            // Clear menu cache when item is deleted
            if ($menuItem->menu) {
                $menuItem->menu->clearCache();
            }
        });
    }
}

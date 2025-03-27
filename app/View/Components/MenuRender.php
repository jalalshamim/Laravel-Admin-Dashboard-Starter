<?php

namespace App\View\Components;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class MenuRender extends Component
{
    public $menu;
    public $items;
    public $class;

    /**
     * Create a new component instance.
     */
    public function __construct($location = null, $name = null, $class = '')
    {
        // Find menu by location or name
        if ($location) {
            $menu = $this->getCachedMenuByLocation($location);
        } elseif ($name) {
            $menu = $this->getCachedMenuByName($name);
        } else {
            $menu = null;
        }

        $this->menu = $menu;
        $this->items = $menu ? $this->getMenuItems($menu) : collect();
        $this->class = $class;
    }

    /**
     * Get cached menu by location
     */
    protected function getCachedMenuByLocation($location)
    {
        $cacheKey = "menu_location_{$location}";
        
        return Cache::remember($cacheKey, now()->addDay(), function () use ($location) {
            return Menu::where('location', $location)
                ->where('status', true)
                ->first();
        });
    }

    /**
     * Get cached menu by name
     */
    protected function getCachedMenuByName($name)
    {
        $cacheKey = "menu_name_{$name}";
        
        return Cache::remember($cacheKey, now()->addDay(), function () use ($name) {
            return Menu::where('name', $name)
                ->where('status', true)
                ->first();
        });
    }

    /**
     * Get menu items
     */
    protected function getMenuItems($menu)
    {
        $cacheKey = "menu_items_{$menu->id}";
        
        return Cache::remember($cacheKey, now()->addDay(), function () use ($menu) {
            return $menu->items()
                ->with('children')
                ->where('status', true)
                ->orderBy('order')
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu-render');
    }
}

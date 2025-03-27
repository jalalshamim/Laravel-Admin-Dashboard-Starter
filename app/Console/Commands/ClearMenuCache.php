<?php

namespace App\Console\Commands;

use App\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearMenuCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:clear-cache {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the menu cache for all menus or a specific menu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $menuId = $this->argument('id');

        if ($menuId) {
            $menu = Menu::find($menuId);
            
            if (!$menu) {
                $this->error("Menu with ID {$menuId} not found.");
                return 1;
            }
            
            $this->clearMenuCache($menu);
            $this->info("Cache cleared for menu '{$menu->name}'.");
        } else {
            $menus = Menu::all();
            
            foreach ($menus as $menu) {
                $this->clearMenuCache($menu);
            }
            
            // Clear location and name based caches
            $this->clearAllMenuCaches();
            
            $this->info('All menu caches cleared successfully.');
        }

        return 0;
    }

    /**
     * Clear cache for a specific menu
     */
    protected function clearMenuCache(Menu $menu)
    {
        // Clear menu items cache
        Cache::forget("menu_{$menu->id}_items");
        Cache::forget("menu_items_{$menu->id}");
        
        // Clear location based cache
        if ($menu->location) {
            Cache::forget("menu_location_{$menu->location}");
        }
        
        // Clear name based cache
        Cache::forget("menu_name_{$menu->name}");
    }

    /**
     * Clear all menu related caches
     */
    protected function clearAllMenuCaches()
    {
        // Get all cache keys related to menus
        $keys = collect(Cache::getStore()->all())->keys()->filter(function ($key) {
            return strpos($key, 'menu_') === 0;
        });
        
        // Forget all menu related caches
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}

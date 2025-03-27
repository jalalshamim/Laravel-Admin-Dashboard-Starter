<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main navigation menu
        $mainMenu = Menu::create([
            'name' => 'Main Navigation',
            'location' => 'header',
            'description' => 'Main site navigation menu',
            'status' => true,
        ]);

        // Create footer menu
        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'location' => 'footer',
            'description' => 'Footer navigation menu',
            'status' => true,
        ]);

        // Add items to main menu
        $homeItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Home',
            'url' => '/',
            'icon' => 'fas fa-home',
            'target' => '_self',
            'order' => 0,
            'status' => true,
        ]);

        $aboutItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'About',
            'url' => '/about',
            'icon' => 'fas fa-info-circle',
            'target' => '_self',
            'order' => 1,
            'status' => true,
        ]);

        $servicesItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Services',
            'url' => '/services',
            'icon' => 'fas fa-cogs',
            'target' => '_self',
            'order' => 2,
            'status' => true,
        ]);

        // Add child items to Services
        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $servicesItem->id,
            'title' => 'Web Development',
            'url' => '/services/web-development',
            'icon' => 'fas fa-laptop-code',
            'target' => '_self',
            'order' => 0,
            'depth' => 1,
            'status' => true,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'parent_id' => $servicesItem->id,
            'title' => 'Mobile App Development',
            'url' => '/services/mobile-development',
            'icon' => 'fas fa-mobile-alt',
            'target' => '_self',
            'order' => 1,
            'depth' => 1,
            'status' => true,
        ]);

        $contactItem = MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Contact',
            'url' => '/contact',
            'icon' => 'fas fa-envelope',
            'target' => '_self',
            'order' => 3,
            'status' => true,
        ]);

        // Add items to footer menu
        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Privacy Policy',
            'url' => '/privacy-policy',
            'target' => '_self',
            'order' => 0,
            'status' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Terms of Service',
            'url' => '/terms-of-service',
            'target' => '_self',
            'order' => 1,
            'status' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Contact Us',
            'url' => '/contact',
            'target' => '_self',
            'order' => 2,
            'status' => true,
        ]);
    }
}

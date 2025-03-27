<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateDemoLogo extends Command
{
    protected $signature = 'demo:logo';
    protected $description = 'Creates a demo logo and adds it to the settings';

    public function handle()
    {
        // Create directory if it doesn't exist
        $directory = storage_path('app/public/logos');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Create a demo SVG logo
        $logo = <<<SVG
<svg width="200" height="50" xmlns="http://www.w3.org/2000/svg">
    <rect width="100%" height="100%" fill="#4F46E5"/>
    <text x="100" y="30" font-family="Arial" font-size="18" fill="white" text-anchor="middle">Admin Panel</text>
</svg>
SVG;

        // Save logo to storage
        $filename = 'logos/demo-logo.svg';
        Storage::disk('public')->put($filename, $logo);
        
        // Update settings
        Setting::updateOrCreate(
            ['key' => 'app_logo'],
            ['value' => $filename]
        );
        
        $this->info('Demo logo created successfully!');
        return Command::SUCCESS;
    }
} 
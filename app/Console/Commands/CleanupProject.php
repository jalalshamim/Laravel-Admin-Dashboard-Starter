<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanupProject extends Command
{
    protected $signature = 'project:cleanup';
    protected $description = 'Clean up unnecessary files and folders from the project';

    protected $foldersToClean = [
        'public/themes', // Unused themes directory
        'public/img/create-default-logo.php', // Temporary script
        'resources/sass', // Unused SASS files (if using compiled CSS)
        'resources/js', // Unused JS files (if using CDN)
        'storage/debugbar', // Debugbar logs
        'storage/logs', // Old logs
    ];

    protected $filesToClean = [
        '.env.example', // Example environment file
        'phpunit.xml', // Test configuration (if not using tests)
        'README.md.example', // Example readme
        'SECURITY.md', // Security policy (if not needed)
    ];

    public function handle()
    {
        $this->info('Starting project cleanup...');
        
        // Clean folders
        foreach ($this->foldersToClean as $folder) {
            $path = base_path($folder);
            
            if (File::exists($path)) {
                if (File::isDirectory($path)) {
                    // Only empty the directory, don't delete it
                    $files = File::allFiles($path);
                    foreach ($files as $file) {
                        File::delete($file);
                    }
                    $this->info("Cleaned directory: {$folder}");
                } else {
                    // It's a file, delete it
                    File::delete($path);
                    $this->info("Deleted file: {$folder}");
                }
            } else {
                $this->line("Skipped (not found): {$folder}");
            }
        }
        
        // Clean files
        foreach ($this->filesToClean as $file) {
            $path = base_path($file);
            
            if (File::exists($path)) {
                File::delete($path);
                $this->info("Deleted file: {$file}");
            } else {
                $this->line("Skipped (not found): {$file}");
            }
        }
        
        // Create a new clean README
        $readmePath = base_path('README.md');
        $readmeContent = "# Marketiva Laravel Admin Starter\n\nVersion 1.0.0\n\nA powerful admin panel built with Laravel and Bootstrap.\n\n## Installation\n\n1. Clone the repository\n2. Run `composer install`\n3. Copy `.env.example` to `.env` and configure your database\n4. Run `php artisan migrate --seed`\n5. Run `php artisan storage:link`\n6. Run `php artisan serve`\n\n## Features\n\n- User Management\n- Role & Permission Management\n- Content Management System\n- Menu Builder\n- Settings Management\n- Activity Logging\n\n## License\n\nThe Marketiva Laravel Admin Starter is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).";
        
        File::put($readmePath, $readmeContent);
        $this->info("Created new README.md");
        
        $this->info('Project cleanup completed successfully!');
        
        return Command::SUCCESS;
    }
} 
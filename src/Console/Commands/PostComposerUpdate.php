<?php

namespace SDLX\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PostComposerUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdlx:post-composer-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the post composer update procedure';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Running SDLX Post Composer update procedure..." . PHP_EOL;

        // Publish Laravel assets
        // ------------------
        Artisan::call('vendor:publish --tag=laravel-assets');

        // Discover SDLX packages
        // ------------------
        Artisan::call('sdlx:discover-packages');

        // Map config files
        // ------------------
        Artisan::call('sdlx:map-config');

        // Update Telescope
        // ------------------
        Artisan::call('telescope:publish');

        echo "SDLX Post Composer update procedure completed!" . PHP_EOL;
    }
}

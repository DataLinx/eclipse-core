<?php

namespace SDLX\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PostComposerInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sdlx:post-composer-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the post composer install procedure';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Running SDLX Post Composer install procedure..." . PHP_EOL;

        // Copy the .env file
        // ------------------
        if (!file_exists('.env')) {
            if (copy('vendor/sdlx/core/.env.example', '.env')) {
                echo ".env.example copied to .env" . PHP_EOL;
                Artisan::call("key:generate --ansi");
            } else {
                die("Could not copy .env.example to .env");
            }
        } else {
            echo ".env already exists" . PHP_EOL;
        }

        // Install Telescope
        // ------------------
        Artisan::call('telescope:install');
    }
}

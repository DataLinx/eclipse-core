<?php

namespace Ocelot\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Ocelot\Core\Console\Commands\OcelotInstall;
use Ocelot\Core\Console\Commands\PostComposerInstall;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       if ($this->app->runningInConsole()) {
           $this->commands([
               PostComposerInstall::class,
               OcelotInstall::class,
           ]);
       }
    }
}

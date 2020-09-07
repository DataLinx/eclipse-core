<?php

namespace Ocelot\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Ocelot\Core\Console\Commands\OcelotInstall;
use Ocelot\Core\Console\Commands\PostComposerInstall;
use Ocelot\Core\Console\Commands\PostComposerUpdate;

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
        $package_dir = __DIR__ .'/../../';

        $this->loadRoutesFrom($package_dir .'routes/web.php');
        $this->loadViewsFrom($package_dir .'resources/views', 'core');
        $this->loadMigrationsFrom($package_dir .'database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PostComposerInstall::class,
                PostComposerUpdate::class,
                OcelotInstall::class,
            ]);
            $this->loadFactoriesFrom($package_dir .'database/factories');
        }
    }
}

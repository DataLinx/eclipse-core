<?php

namespace Ocelot\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Ocelot\Core\Console\Commands\DiscoverPackages;
use Ocelot\Core\Console\Commands\MapConfig;
use Ocelot\Core\Console\Commands\OcelotInstall;
use Ocelot\Core\Console\Commands\PostComposerInstall;
use Ocelot\Core\Console\Commands\PostComposerUpdate;
use Ocelot\Core\Framework\Context;
use Ocelot\Core\Framework\L10n;
use Ocelot\Core\View\Components\Alert;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('context', function() {
            return new Context();
        });

        $this->app->singleton('l10n', function() {
            return new L10n();
        });

        $this->app->singleton('glide', function() {
            return ServerFactory::create([
                'response' => new LaravelResponseFactory(app('request')),
                'source' => app_base_path('storage/app'),
                'cache' => app_base_path('storage/app/cache'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(package_path('ocelot/core', 'routes/web.php'));
        $this->loadViewsFrom(package_path('ocelot/core', 'resources/views'), 'core');
        $this->loadMigrationsFrom(package_path('ocelot/core', 'database/migrations'));

        if ($this->app->runningInConsole()) {
            $this->commands([
                PostComposerInstall::class,
                PostComposerUpdate::class,
                OcelotInstall::class,
                DiscoverPackages::class,
                MapConfig::class,
            ]);
        }

        $this->publishes([
            package_path('ocelot/core', 'public') => public_path('vendor/ocelot/core'),
        ], 'ocelot/core');

        Blade::componentNamespace('Ocelot\\Core\\View\\Components\\Form', 'form');
        Blade::component(Alert::class);
    }
}

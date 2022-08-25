<?php

namespace SDLX\Core\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use SDLX\Core\Console\Commands\DiscoverPackages;
use SDLX\Core\Console\Commands\MapConfig;
use SDLX\Core\Console\Commands\PostComposerInstall;
use SDLX\Core\Console\Commands\PostComposerUpdate;
use SDLX\Core\Console\Commands\SDLXInstall;
use SDLX\Core\Framework\Context;
use SDLX\Core\Framework\L10n;
use SDLX\Core\Framework\Output;
use SDLX\Core\Models\PersonalAccessToken;
use SDLX\Core\View\Components\Alert;
use SDLX\Core\View\Components\AppLayout;
use SDLX\Core\View\Components\Icon;

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

        $this->app->singleton(Output::class, function() {
            return new Output();
        });

        $this->app->singleton('glide', function() {
            return ServerFactory::create([
                'response' => new LaravelResponseFactory(app('request')),
                'source' => base_path('storage/app'),
                'cache' => base_path('storage/app/cache'),
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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'core');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PostComposerInstall::class,
                PostComposerUpdate::class,
                SDLXInstall::class,
                DiscoverPackages::class,
                MapConfig::class,
            ]);
        }

        Blade::componentNamespace('SDLX\\Core\\View\\Components\\Form', 'form');
        Blade::component(AppLayout::class);
        Blade::component(Alert::class);
        Blade::component(Icon::class);

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}

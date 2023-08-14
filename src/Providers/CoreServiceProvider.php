<?php

namespace Eclipse\Core\Providers;

use Exception;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use Livewire\Livewire;
use Eclipse\Core\Console\Commands\DiscoverPackages;
use Eclipse\Core\Console\Commands\MapConfig;
use Eclipse\Core\Console\Commands\PostComposerInstall;
use Eclipse\Core\Console\Commands\PostComposerUpdate;
use Eclipse\Core\Console\Commands\EclipseInstall;
use Eclipse\Core\Framework\Context;
use Eclipse\Core\Framework\L10n;
use Eclipse\Core\Framework\Output;
use Eclipse\Core\Framework\Output\Menu;
use Eclipse\Core\Models\PersonalAccessToken;
use Eclipse\Core\View\Components\Alert;
use Eclipse\Core\View\Components\AppLayout;
use Eclipse\Core\View\Components\Icon;
use Eclipse\Core\View\Grids\Users as UsersGrid;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        require_once app_path('../vendor/datalinx/php-utils/src/fluent_helpers.php');

        $this->app->singleton('context', function() {
            return new Context();
        });

        $this->app->singleton('l10n', function() {
            return new L10n();
        });

        $this->app->singleton(Output::class, function() {
            return new Output();
        });

        $this->app->singleton(Menu::class, function () {
            app('l10n')->setDomain('core');

            $menu = new Menu();

            $menu->addItem(new Menu\Item(_('Dashboard'), url('dashboard')))
                ->addItem(new Menu\Item(_('Users'), url('users')));

            if ($this->app->environment('local')) {
                // Menu that is visible only in development
                $tools = new Menu\Section(_('Tools'), null, 'tools');
                $tools->addItem(new Menu\Item(_('Visual component test'), url('test/components')));
                $menu->addItem($tools);
            }

            return $menu;
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
     * @throws Exception
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'core');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PostComposerInstall::class,
                PostComposerUpdate::class,
                EclipseInstall::class,
                DiscoverPackages::class,
                MapConfig::class,
            ]);
        }

        Blade::componentNamespace('Eclipse\\Core\\View\\Components\\Form', 'form');
        Blade::component(AppLayout::class);
        Blade::component(Alert::class);
        Blade::component(Icon::class);

        if (! $this->app->environment('testing')) {
            Livewire::component('users-grid', UsersGrid::class);
        }

        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}

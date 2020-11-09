<?php

namespace MarksIhor\LaravelPermissions;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class MetasServiceProvider.
 */
class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // Controllers
        $this->publishes([
            __DIR__ . '/../src/Http/Controllers' => app_path('Http/Controllers')
        ], 'controllers');

        // Migrations
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        // Config
        $this->publishes([
            __DIR__ . '/../configs/' => config_path()
        ], 'configs');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }

        $this->mergeConfigFrom(__DIR__ . '/../configs/roles.php', 'roles');

        if (config('roles.routes.built_in')) {
            $this->loadRoutes();
        }
    }

    /**
     * Group the routes and set up configurations to load them.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        Route::group($this->routesConfigurations(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });
    }

    /**
     * Routes configurations.
     *
     * @return array
     */
    private function routesConfigurations()
    {
        return [
            'prefix' => config('roles.routes.prefix'),
            'namespace' => config('roles.routes.namespace'),
            'middleware' => config('roles.routes.middleware'),
        ];
    }
}

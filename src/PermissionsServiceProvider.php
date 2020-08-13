<?php

namespace MarksIhor\LaravelPermissions;

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
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }
    }
}

<?php

namespace Shrft\AdminBar;

use Illuminate\Support\ServiceProvider;
use Shrft\AdminBar\Middleware\AdminBarMiddleware;

class AdminBarServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/adminbar.php', 'adminbar'
        );
    }

    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        $this->registerMiddleware(AdminBarMiddleware::class);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminbar');
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/adminbar'),
        ], 'public');
        $this->publishes([
            __DIR__.'/../config/adminbar.php' => config_path('adminbar.php'),
        ]);
    }

    /**
     * Register Admin Bar middleware.
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app['router'];
        $kernel->pushMiddlewareToGroup('web', $middleware);
    }
}

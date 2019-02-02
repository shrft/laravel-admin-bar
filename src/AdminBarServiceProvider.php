<?php

namespace Shrft\AdminBar;
use Shrft\AdminBar\Middleware\AdminBarMiddleware;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class AdminBarServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/adminbar.php', 'adminbar'
        );
    }
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMiddleware(AdminBarMiddleware::class);

       $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminbar');
        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/adminbar'),
        ], 'public');
        $this->publishes([
            __DIR__ . '/../config/adminbar.php' => config_path('adminbar.php'),
        ]);
    }
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app['router'];
        $kernel->pushMiddlewareToGroup('web', $middleware);
    }
}

<?php

// todo@shira: shrftもnamespaceにいれたほうがいい
namespace AdminBar;
use AdminBar\Middleware\AdminBarMiddleware;

use Illuminate\Support\Facades\Route;
use Wink\Http\Middleware\Authenticate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class AdminBarServiceProvider extends ServiceProvider
{
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


    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
    }
    /**
     * Register the Debugbar Middleware
     *
     * @param  string $middleware
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }
}

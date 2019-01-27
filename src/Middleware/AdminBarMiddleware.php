<?php

namespace AdminBar\Middleware;

use Closure;
use Illuminate\Http\Response;
use AdminBar\AdminBar;

class AdminBarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $bar = new AdminBar($request, config('adminbar.excludes'), config('adminbar.is_admin'));

        //todo@shira:このあたりのチェックも必要かも
        //!$this->app->runningInConsole() && !$this->app->environment('testing');
        // Show the Http Response Exception in the Debugbar, when available
        //if (isset($response->exception)) {
        //    $this->addThrowable($response->exception);
        //}


        if(config('adminbar.enabled') && $bar->shouldShow()){
            $response = $bar->injectAdminBar($response, config('adminbar.menus'));
        }

        return $response;
    }
}

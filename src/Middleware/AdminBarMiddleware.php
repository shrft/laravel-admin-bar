<?php

namespace Shrft\AdminBar\Middleware;

use Closure;
use Illuminate\Http\Response;
use Shrft\AdminBar\AdminBar;

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
        if( config('adminbar.enabled') && $bar->shouldShow()){
            $response = $bar->injectAdminBar($response, config('adminbar.menus'));
        }

        return $response;
    }
}

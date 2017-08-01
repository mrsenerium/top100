<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeLogViewer
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
        //deny access to logs unless admin
        if(!auth()->user() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Access Denied');
        }
        return $next($request);
    }
}

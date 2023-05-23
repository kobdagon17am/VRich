<?php

namespace App\Http\Middleware;

use Closure;
use Admin;

class Admin
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
        if (Admin::check() && Admin::user()->isAdmin()) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}

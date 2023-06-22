<?php

namespace App\Http\Middleware;

use Closure;

class HasAccessToken
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
        // Pre-Middleware Action

        $request['_with_token'] = '';
        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}

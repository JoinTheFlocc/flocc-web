<?php

namespace Flocc\Http\Middleware;

use Closure;

class SendActivationEmail
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
        //echo "registration middleware handler";
        return $next($request);
    }
}

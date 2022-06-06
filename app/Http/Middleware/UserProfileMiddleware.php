<?php

namespace Bukosan\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserProfileMiddleware
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
        if(is_null($request->user()->nik))
            return redirect()->route('settings');
        return $next($request);
    }

}

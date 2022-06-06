<?php

namespace Bukosan\Http\Middleware;

use Closure;

class SuspendMiddleware
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
		if($request->user()->ditangguhkan)
			return redirect()->route('ditangguhkan');
        return $next($request);
    }
}

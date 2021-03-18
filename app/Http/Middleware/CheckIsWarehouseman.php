<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckIsWarehouseman
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (\Gate::allows(env("IS_WAREHOUSEMAN"),\Auth::user())) {
            return $next($request);
        }
        return redirect()->route('home');
    }
}

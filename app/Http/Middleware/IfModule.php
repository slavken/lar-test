<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class IfModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module = null)
    {
        if (Auth::check()) {
            if (Auth::user()->module !== $module)
                return response()->json(['message' => 'Forbidden.'], 403);
        }
        
        Config::set('module', $module);

        return $next($request);
    }
}

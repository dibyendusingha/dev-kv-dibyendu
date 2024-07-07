<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ipAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
     public $attributes;
     
    public function handle(Request $request, Closure $next)
    {
        
        $response = $next($request);
        $ip = '202.142.105.197';//\Request::ip();
        $location_data = \Location::get($ip);
        
        $request->attributes->add(['location_data' => $location_data]);
        
        return $next($request);
    }
}

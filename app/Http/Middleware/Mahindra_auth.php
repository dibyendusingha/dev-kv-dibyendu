<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Mahindra_auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('admin-krishi-mahindra')) {
            return redirect('index');
        } else {
            return redirect('krishi-vikash-mahindra-login');
        }
        return $next($request);
    }
}

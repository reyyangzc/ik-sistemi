<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role_id == 1) {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->withErrors(['message' => 'Bu sayfaya erişim yetkiniz yok.']);
    }
}

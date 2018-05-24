<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // User đã chứng thực, điều hướng về route home
            // Không vượt qua được middleware
            return redirect('/admin/home');
        }

        // Cho phép yêu cầu route vượt qua middleware
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // guard
            if (Auth::guard($guard)->check() && $request->getRequestUri() != '/register') {
                return redirect(RouteServiceProvider::HOME);
            }

            // If user that is not LOGGED IN or ADMIN visits any route other than /login redirect to login
            if ($request->getRequestUri() != '/login' && (Auth::user() == null || Auth::user()->type_id != 1)) {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}

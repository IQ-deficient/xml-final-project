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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // Ako je ruta razlicita od register skipuj ovaj if
            if (Auth::guard($guard)->check() && $request->getRequestUri() != '/register') {
                return redirect(RouteServiceProvider::HOME);
            }

            // Ako je ruta razlicita od login i user nije logovan i nije admin baci ga na login
            // Provjera da nije ruta login je obavezna kako se ne bi stvorila beskonacna petlja
            if($request->getRequestUri() != '/login' && (Auth::user() == null || Auth::user()->type_id != 1)) {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}

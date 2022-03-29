<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
            return redirect('admin-home');
        }

        return $next($request);

        // $guards = empty($guard) ? [null] : $guard;

        // foreach ($guards as $guard) {
        //     if (Auth::guard($guard)->check()) {
        //         if($guards=='customers')
        //         {
        //          return redirect(RouteServiceProvider::CUSTOMER_HOME);
        //         }
        //         return redirect(RouteServiceProvider::HOME);
        //     }
        // }

        // return $next($request);
    }
}

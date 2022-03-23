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
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if($guard === 'admin')
                {
                    return redirect()->route('admin.home');
                }
                elseif($guard === 'vendor')
                {
                    return redirect()->route('vendor.home');
                }
                else
                {
                    return redirect()->route('dashboard');
                }

                // switch($guard)
                // {
                //     case 'admin':
                //         if(Auth::guard($guard)->check())
                //         {
                //             return redirect()->route('admin.home');
                //         }
                //     break;
                //     case 'vendor':
                //         if(Auth::guard($guard)->check())
                //         {
                //             return redirect()->route('vendor.home');
                //         }
                //     break;
                //     default:
                //         if(Auth::guard($guard)->check())
                //         {
                //             return redirect()->route('dashboard');
                //         }
                //     break;
                // }

            }
        }
        return $next($request);
    }
}

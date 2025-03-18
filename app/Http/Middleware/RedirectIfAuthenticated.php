<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * @category Middleware
 * @package  App\Http\Middleware

 */
class RedirectIfAuthenticated
{


    /**
     * Handle an incoming request.
     *
     * @param Request                                       $request   // Request
     * @param Closure(Request): (Response|RedirectResponse) $next      // Closure
     * @param string|null                                   ...$guards // Param
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);

    }//end handle()


}//end class

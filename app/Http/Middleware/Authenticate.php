<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Authenticate
 *
 * @category Middleware
 * @package  App\Http\Middleware

 */
class Authenticate extends Middleware
{


    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request // Request
     *
     * @return void
     */
    protected function redirectTo($request): void
    {
        //        if (!$request->expectsJson()) {
        //            return false;
        //        }

    }//end redirectTo()


}//end class

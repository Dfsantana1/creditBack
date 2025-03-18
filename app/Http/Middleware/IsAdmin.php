<?php

namespace App\Http\Middleware;

use App\Enums\User\UserRoleEnum;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response as aliasResponse;
use \Illuminate\Http\Response;

/**
 * Class IsAdmin
 *
 * @category Middleware
 * @package  App\Http\Middleware

 */
class IsAdmin
{


    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return Response|JsonResponse|BinaryFileResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse|BinaryFileResponse
    {
        if (!empty(Auth::user())) {
            $userRoles = collect(Auth::user()->rolesArray());
            if ($userRoles->contains(UserRoleEnum::ADMIN->name)) {
                return $next($request);
            }
        }

        return response()
            ->json(['message' => 'Unauthorized'])
            ->setStatusCode(aliasResponse::HTTP_UNAUTHORIZED);

    }//end handle()


}//end class

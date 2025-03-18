<?php

namespace App\Http\Middleware;

use App\Models\Auth\AuthClient;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IsSecureClientAccess
 *
 * @category Middleware
 * @package  App\Http\Middleware
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class IsSecureClientAccess
{


    /**
     * Handle an incoming request.
     *
     * @param  Request                                           $request
     * @param  Closure(Request): (JsonResponse|RedirectResponse) $next
     * @return JsonResponse|RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|RedirectResponse
    {
        $clientSecret = $request->header('Client-Secret');
        $clientId     = $request->header('Client-Id');

        if ($clientSecret && $clientId) {
            $client = AuthClient::query()
                ->where('id', $clientId)
                ->where('secret', $clientSecret)
                ->where('revoked', '0')
                ->first();

            if ($client) {
                return $next($request);
            }
        }

        return response()
            ->json(['message' => 'Unauthorized'])
            ->setStatusCode(Response::HTTP_UNAUTHORIZED);

    }//end handle()


}//end class

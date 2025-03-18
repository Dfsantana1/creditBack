<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LogoutController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Auth

 */
class LogoutController extends Controller
{


    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        ## Get User
        $user = auth('sanctum')->user();
        if (empty($user)) {
            return response()
                ->json(['error' => 'Record not found.'])
                ->setStatusCode(Response::HTTP_NOT_FOUND);
        }

        $user->tokens()->delete();
        return response()
            ->json(['message' => 'Logout successful'])
            ->setStatusCode(Response::HTTP_OK);

    }//end __invoke()


}//end class

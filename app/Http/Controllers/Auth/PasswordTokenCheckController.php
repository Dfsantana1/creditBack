<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordTokenCheckRequest;
use App\Models\User\PasswordReset;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PasswordTokenCheckController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Auth

 */
class PasswordTokenCheckController extends Controller
{


    /**
     * @param  PasswordTokenCheckRequest $request
     * @return JsonResponse
     */
    public function __invoke(PasswordTokenCheckRequest $request): JsonResponse
    {
        $passwordReset = PasswordReset::query()
            ->where('email', $request->input('email'))
            ->where('token', $request->input('token'))
            ->first();

        if (empty($passwordReset)) {
            return response()
                ->json(['message' => 'Invalid token'])
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Check if not expired
        if (now()->subHours(1) > Carbon::create($passwordReset->createdAt)) {
            return response()
                ->json(['message' => 'Password token expired'])
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()
            ->json($passwordReset)
            ->setStatusCode(Response::HTTP_OK);

    }//end __invoke()


}//end class

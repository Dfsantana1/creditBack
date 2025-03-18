<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\EmailTrackingTypes;
use App\Enums\SentEmailStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordForgotRequest;
use App\Mail\SendTokenResetPassword;
use App\Models\EmailTracking\EmailTracking;
use App\Models\User\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PasswordForgotController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Auth

 */
class PasswordForgotController extends Controller
{


    /**
     * @param  \App\Http\Requests\Auth\PasswordForgotRequest $request
     * @return JsonResponse
     */
    public function __invoke(PasswordForgotRequest $request): JsonResponse
    {
        // Delete All Previous Codes
        PasswordReset::query()->where('email', $request->input('email'))->delete();

        // Generate random code
        $data = [
            'token' => mt_rand(100000, 999999),
            'email' => $request->input('email'),
        ];

        $codeData = PasswordReset::query()->create($data);

        // Send email to user
        $sendEmail = Mail::to($request->input('email'))->send(new SendTokenResetPassword($codeData));

        $html = view('mail.password-reset', ['passwordReset' => $codeData])->render();

        EmailTracking::create(
            [
                'emailId'  => Str::replace(["<", ">"], "", $sendEmail->getMessageId()),
                'sender'   => $sendEmail->getEnvelope()->getSender()->getAddress(),
                'receiver' => $request->input('email'),
                'body'     => $html,
                'userId'   => null,
                'active'   => 1,
                'status'   => SentEmailStatus::QUEUE->value,
                'type'     => EmailTrackingTypes::PASSWORD_FORGOT->value,
            ]
        );
        return response()
            ->json(['message' => 'Password sent'])
            ->setStatusCode(Response::HTTP_OK);

    }//end __invoke()


}//end class

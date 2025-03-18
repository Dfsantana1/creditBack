<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\EmailTrackingTypes;
use App\Enums\SentEmailStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordResetRequest;
use App\Mail\SendConfirmationResetPassword;
use App\Models\EmailTracking\EmailTracking;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PasswordResetController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Auth

 */
class PasswordResetController extends Controller
{


    /**
     * @param  PasswordResetRequest $request
     * @return JsonResponse
     */
    public function __invoke(PasswordResetRequest $request): JsonResponse
    {
        /**
 * @var User $user
*/
        $user           = User::query()->where('email', $request->input('email'))->first();
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Send email to user TODO
        $sendEmail = Mail::to($request->input('email'))->send(new SendConfirmationResetPassword($user));

        $html = view('mail.confirm-reset', ['user' => $user])->render();

        EmailTracking::create(
            [
                'emailId'  => Str::replace(["<", ">"], "", $sendEmail->getMessageId()),
                'sender'   => $sendEmail->getEnvelope()->getSender()->getAddress(),
                'receiver' => $user->email,
                'body'     => $html,
                'userId'   => $user->id,
                'active'   => 1,
                'status'   => SentEmailStatus::QUEUE->value,
                'type'     => EmailTrackingTypes::CONFIRMATION_RESET_PASSWORD->value,
            ]
        );

        return response()
            ->json(['message' => 'Password reset successful'])
            ->setStatusCode(Response::HTTP_OK);

    }//end __invoke()


}//end class

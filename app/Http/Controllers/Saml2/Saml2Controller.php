<?php

namespace App\Http\Controllers\Saml2;

use App\Events\Saml2\SignedOut;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use OneLogin\Saml2\ValidationError;
use Slides\Saml2\Auth;
use Illuminate\Http\Request;
use Slides\Saml2\Events\SignedIn;
use OneLogin\Saml2\Error as OneLoginError;
use Slides\Saml2\Http\Controllers\Saml2Controller as Saml2BaseController;

/**
 * Class Saml2Controller
 *
 * @category Controller
 * @package  App\Http\Controllers\Saml2
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class Saml2Controller extends Saml2BaseController
{


    /**
     * Acs
     *
     * @param Auth $auth
     *
     * @return Application|RedirectResponse|Redirector|void [type]
     */
    public function acs(Auth $auth)
    {
        try {
            $errors = $auth->acs();
        } catch (OneLoginError | ValidationError $e) {
            Log::channel('okta')->info('Single Sign-on Login'.$e->getMessage());

            return redirect(config('saml2.errorRoute'));
        }

        if (!empty($errors)) {
            logger()->error('saml2.error_detail', ['error' => $auth->getLastErrorReason()]);
            session()->flash('saml2.error_detail', [$auth->getLastErrorReason()]);

            logger()->error('saml2.error', $errors);
            session()->flash('saml2.error', $errors);

            return redirect(config('saml2.errorRoute'));
        }

        $user = $auth->getSaml2User();

        $data = event(new SignedIn($user, $auth));

        if (isset($data[0]['error'])) {
            $redirectUrl     = str_replace('{token}',  'TOKEN_NOT_FOUND', ($user->getIntendedUrl() ?? config('saml2.loginRoute')));
            $queryParameters = Arr::query($data[0]);
            return redirect($redirectUrl."?".$queryParameters);
        }

        $userToken = $data[0]['userToken'];

        $redirectUrl = ($user->getIntendedUrl() ?? config('saml2.loginRoute'));
        $redirectUrl = str_replace('{token}', $userToken, $redirectUrl);

        if ($redirectUrl) {
            return redirect($redirectUrl);
        }

        return redirect($auth->getTenant()->relay_state_url ?: config('saml2.loginRoute'));

    }//end acs()


    /**
     * Initiate a logout request.
     *
     * @param Request $request
     * @param Auth    $auth
     *
     * @return void
     *
     * @throws OneLoginError
     */
    public function logout(Request $request, Auth $auth)
    {
        Log::channel('okta')->info('Single Sign-on Logout');
        Log::channel('okta')->info('Logout auth data: '.json_encode($auth));

        $user = $auth->getSaml2User();
        Log::channel('okta')->info('Logout user data: '.json_encode($user));

        $logoutSloUrl = $auth->logout(config('saml2.logoutRoute'), $request->query('nameId'), $request->query('sessionIndex'), null, true);
        Log::channel('okta')->info('Saml2 Logout completed');

        try {
            event(new SignedOut($user, $auth));
            Log::channel('okta')->info('Saml2 Logout event processed.');
        } catch (Exception $exception) {
            Log::channel('okta')->info('Logout error.'.$exception->getMessage());
        }

        \Illuminate\Support\Facades\Auth::logout();
        Session::invalidate();
        return redirect($logoutSloUrl);

    }//end logout()


}//end class

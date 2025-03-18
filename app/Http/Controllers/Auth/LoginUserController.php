<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\User\Role;
use App\Helpers\GeoHelper;
use App\Helpers\UserHelper;
use App\Models\Media\Media;
use Illuminate\Support\Str;
use App\Enums\ImageSizeEnum;
use Illuminate\Http\Request;
use App\Enums\OktaActionType;
use App\Models\User\UserRole;
use Illuminate\Validation\Rule;
use App\Enums\User\UserRoleEnum;
use App\Models\User\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\OktaRequests\OktaRequest;
use App\Models\User\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\UserEmailRequest;
use App\Http\Controllers\User\UserController;
use App\Http\Requests\Auth\LoginUserIdRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Media\MediaController;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Requests\User\UserOktaTokenRequest;
use App\Http\Requests\Media\UploadFileUrlRequest;


/**
 * Class LoginUserController
 *
 * @extends  Controller controller
 * @category Controllers
 * @package  App\Http\Controllers\Auth
 * @author   Diego Santana <dsantanafernandez@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class LoginUserController extends Controller
{


    /**
     * Login User
     *
     * @param  LoginRequest $credentials
     * @return JsonResponse
     */
    public function login(LoginRequest $credentials): JsonResponse
    {
        if (Auth::attempt($credentials->only('email', 'password'))) {
			$user = User::query()->where('email', $credentials->input('email'))
			->whereHas(
				'profile',
				function ($q) {
					$q->whereNull('archivedAt')
						->whereNull('deletedAt');
				}
			)
			->firstOrFail();
            // Revoke all tokens...
            //            $user->tokens()->delete();
            // Create new Token
			log::info($user);
            $token       = $user->createToken('auth_token');
			log::info($token);

            $token->user = UserResource::make($user);
            // Insert GeoLocation
            // PersonalAccessToken::query()
            //     ->where('id', $token->accessToken->id)
            //     ->update(['geoLocation' => GeoHelper::getGeoLocation()]);
            return response()->json(['data' => $token]);
        }

        return response()->json(
            ['message' => 'Invalid login details'],
            Response::HTTP_UNAUTHORIZED
        );

    }//end login()


	/**
     * Login Google User
     *
     * @return JsonResponse
     */
    public function externalAuthRedirect(Request $request)
    {
		if($request->input('role') && $request->input('provider')){
			$provider = $request->input('provider');
			$role = $request->input('role');
			session([
				'role' => $role,
				'provider' => $provider
			]);
			return Socialite::driver($provider)->redirect();
			// return Socialite::driver($provider)->stateless()->redirect();
			// return Socialite::driver($provider)->setScopes(['openid', 'email'])->redirect();
		}

		return response()->json(
            ['message' => 'Invalid login details'],
            Response::HTTP_UNAUTHORIZED
        );
    }//end googleogin()


	/**
     * Login Google User Callback
     *
     */
    public function externalAuthCallback()
    {	
		try{
			$role = session('role');
			$provider = session('provider');
			$clientRedirect = env('EXTERNAL_CLIENT_REDIRECT') ?? 'https://lazomascotas.com:444/#/';
	
			if($provider === 'twitter'){
				$authUser = Socialite::driver($provider)->user();
				$firstName = $authUser->name;
				$lastName = '';
			} else {
				$authUser = Socialite::driver($provider)->stateless()->user();
				if($provider === 'google'){
					$firstName = $authUser->user['given_name'];
					$lastName = $authUser->user['family_name'];
				} else {
					$firstName = $authUser->name;
					$lastName = '';
				}
			}
			if($authUser && $role){
				$validator = Validator::make(['email' => $authUser->email], [
					'email' => [
						'required',
						'email',
						Rule::unique('users')->where(function ($query) use ($provider) {
							$query
								->where(function ($query) use ($provider) {
									$query->whereNull('socialiteProvider')
										->orWhere('socialiteProvider', '!=', $provider);
									});
						}),
					],
				]);
				if ($validator->fails()) {
					return redirect()->to($clientRedirect . 'account/auth/login-2?error=' . urlencode('El email ya ha sido tomado'));
				}

	
				$currentDate = \Carbon\Carbon::now();
				$userExist = User::where('socialiteId', $authUser->id)->first();
				$user = User::updateOrCreate(
				[
					'socialiteId' => $authUser->id,
				], 
				[
					'email' => $authUser->email,
					'oAuthToken' => $authUser->token,
					'socialiteId' => $authUser->id,
					'socialiteProvider' => $provider,
					'emailConfirmedAt' => $currentDate,
					'password' => $userExist ? $userExist->password : Str::random(32)
				]);
				UserProfile::updateOrCreate(
					[
						'userId'        => $user->id,
					], 
					[
						'userId'        => $user->id,
						'firstName'     => $firstName,
						'lastName'      => $lastName,
						'urlSlug'       => UserHelper::createUniqueUserSlug($firstName, $lastName),
					]
				);
	
				$role = Role::query()->where('name', $role)->first();
				UserRole::updateOrCreate(
					[
						'userId' => $user->id,
					], 
					[
						'userId' => $user->id,
						'roleId' => $role->id,
					]
				);
				$token = $user->createToken('auth_token');
	
		
				$mediaRequestData = [
					'url' => $authUser->avatar,
				];
				$mediaRequest = new UploadFileUrlRequest($mediaRequestData);
				$result = (new MediaController)->uploadFileFromUrl($mediaRequest);
	
				if($result){
					$userRequestData = [
						'mediaId' => $result->original[0]->id,
						'userId' => $user->id
					];
					$userRequest = new UserUpdateProfileRequest($userRequestData);
					$mediaUpdated = (new UserController)->updateProfileMedia($userRequest);
				}
				$token->user = UserResource::make($user);
				return redirect()->to($clientRedirect . 'account/auth/login-2?token=' . urlencode(json_encode($token)));
			} else {
				return redirect()->to($clientRedirect . 'account/auth/login-2?error=' . urlencode('Failed to connect with the provider'));
			}
			return redirect()->to($clientRedirect . 'account/auth/login-2?error=' . urlencode('Failed to connect with the provider'));
		} catch (\Exception $e) {
        	return redirect()->to($clientRedirect . 'account/auth/login-2?error=' . urlencode('Failed to connect with the provider'));
    	}
    }//end googleAuthCallback()


    /**
     * Login Using User Id
     *
     * @param  LoginUserIdRequest $request
     * @return JsonResponse
     */
    public function loginById(LoginUserIdRequest $request): JsonResponse
    {
        $user = User::find($request->input('userId'));
        // Revoke all tokens...
        //        $user->tokens()->delete();
        // Create new Token
        $token       = $user->createToken('auth_token');
        $token->user = UserResource::make($user);
        return response()->json(['data' => $token]);

    }//end loginById()


    /**
     * @param  UserEmailRequest $emailRequest
     * @return JsonResponse
     */
    public function loginByEmail(UserEmailRequest $emailRequest): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = User::query()->where('email', trim($emailRequest->get('email')))->first();
		log::info($user);	

        // Revoke all tokens...
        //        $user->tokens()->delete();
        // Create new Token
        $token       = $user->createToken('auth_token');
		log::info($token);
        $token->user = UserResource::make($user);

        return response()->json(['data' => $token]);

    }//end loginByEmail()

}//end class

<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Models\User\Role;
use App\Models\User;
use App\Helpers\UserHelper;
use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Form\Response;
use App\Models\User\UserRole;
use App\Services\UserService;
use Illuminate\Support\Carbon;
use App\Models\User\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\UserUpdateProfileRequest;
use App\Http\Requests\User\UserUpdateRoleRequest;
use App\Http\Requests\Auth\UserPasswordUpdateRequest;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Class UserController
 *
 * @extends  Controller
 * @category Controllers
 * @package  App\Http\Controllers

 */
class UserController extends Controller
{
    use ScopesTrait, UploadTrait;


    /**
     * Get User Info By Session
     *
     * @param  PaginationRequest $request
     * @return JsonResponse
     */
    public function getArchived(PaginationRequest $request): JsonResponse
    {

        $builder = User::query()->withTrashed()
            ->select(['users.*'])
            ->join('userProfiles', 'userProfiles.userId', 'users.id')
            ->whereRaw('(userProfiles.deletedAt IS NOT NULL OR users.deletedAt IS NOT NULL OR userProfiles.archivedAt IS NOT NULL)');

        if ($request->has('q')) {
            $q = $request->get('q');
            $builder->where(
                function ($query) use ($q) {
                    $query->whereRaw('userProfiles.firstName LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.lastName LIKE ?', "%{$q}%")
                        ->orWhereRaw('CONCAT(userProfiles.firstName, \' \', userProfiles.lastName) LIKE ?', "%{$q}%")
                        ->orWhereRaw('users.email LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.code LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.preferredName LIKE ?', "%{$q}%");
                }
            );
        }

        if (request()->has('filters.confirmedEmailInd')) {
            $builder->whereNotNull('emailConfirmedAt');
        }

        if (request()->has('filters.email')) {
            $builder->where('email', request()->input('filters.email'));
        }

        if (request()->has('filters.roles')) {
            $builder->join('userRoles', 'users.id', 'userRoles.userId')
                ->whereNull('userRoles.deletedAt');
        }

        if (request()->has('filters.roles')) {
            $builder->join('roles', 'roles.id', 'userRoles.roleId')
                ->whereIn('roles.name', request()->input('filters.roles'));
        }

        return response()
            ->json(UserResource::collection($builder->get()))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getArchived()


    /**
     * Get User Info By Session
     *
     * @return JsonResponse
     */
    public function getBySession(): JsonResponse
    {
        ## Get User
        $user = auth('sanctum')->user();
        if (empty($user)) {
            return response()
                ->json(['message' => 'User not found'])
                ->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()
            ->json(UserResource::make($user))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getBySession()


    /**
     * @return JsonResponse
     */
    public function getRoleList(): JsonResponse
    {
        return response()
            ->json(Role::all())
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getRoleList()


    /**
     * @param  User $user
     * @return JsonResponse
     */
    protected function getResponsesTree(User $user): JsonResponse
    {
        $userService      = new UserService();
        $residentResponse = $userService->getUserFieldResponse($user);

        return response()
            ->json($residentResponse)
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getResponsesTree()


    /**
     * Update logged user password
     *
     * @param  UserPasswordUpdateRequest $request
     * @return JsonResponse
     */
    public function updatePassword(UserPasswordUpdateRequest $request): JsonResponse
    {
        /**
         * @var User $user
         */

        $user = auth('sanctum')->user();
        if (empty($user)) {
            return response()
                ->json(['message' => 'User not found'])
                ->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
        }

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return response()
            ->json(UserResource::make($user))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end updatePassword()


    /**
     * @param  User                 $user
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(User $user, Request $request): JsonResponse
    {
        $user->email = $request->input('email');
        $user->save();

        $userProfile            = $user->profile;
        $userProfile->firstName = $request->input('firstName');
        $userProfile->lastName  = $request->input('lastName');

        $userProfile->about            = $request->input('about');
        $userProfile->preferredName    = $request->input('preferredName');
        $userProfile->save();

        return response()
            ->json(UserResource::make($user))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end update()



    /**
     * Update User Role
     *
     * @param  UserUpdateRoleRequest $request
     * @return JsonResponse
     */
    public function updateRole(UserUpdateRoleRequest $request): JsonResponse
    {
        $newRole = Role::query()->where('name', $request->input('role'))->first();
        /**
         * @var UserRole $userRole
         */
        $userRole = UserRole::query()->where('userId', $request->input('userId'))->first();
        UserRole::query()->create(
            [
                'userId'       => $userRole->userId,
                'roleId'       => $newRole->id,
                'roleableId'   => $userRole->roleableId,
                'roleableType' => $userRole->roleableType,
            ]
        );
        $userRole->delete();
        return response()
            ->json(['message' => 'User Updated'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end updateRole()


    /**
     * Update Profile Media
     *
     * @param  UserUpdateProfileRequest $request
     * @return JsonResponse
     */
    public function updateProfileMedia(UserUpdateProfileRequest $request): JsonResponse
    {
        UserProfile::query()
            ->where('userId', $request->get('userId'))
            ->update(['mediaId' => $request->get('mediaId')]);
        return response()
            ->json(['message' => 'User Profile Updated.'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end updateProfileMedia()


    /**
     * Archived User
     *
     * @param  User $user
     * @return JsonResponse
     */
    public function archive(User $user): JsonResponse
    {
        // Archive UserProfile
        $userProfile = $user->profile;
        $userProfile->archivedAt = \Carbon\Carbon::now();
        $userProfile->save();
        //        $user->delete();

        return response()
            ->json(['message' => 'User Archived Updated'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end archive()


    /**
     * Restore User
     *
     * @param  string $userId
     * @return JsonResponse
     */
    public function restore(string $userId): JsonResponse
    {
        // Restore UserProfile
        $user         = User::withTrashed()->find($userId);
        $archivedDate = Carbon::parse($user->profile->archivedAt);
        $user->restore();
        UserProfile::query()->where('userId', $userId)
            ->update(['archivedAt' => null]);
        return response()
            ->json(['message' => 'User restored successful'])
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end restore()





    /**
     * Get User by encoded url code and slug
     *
     * @param  string $hash
     * @param  string $urlSlug
     * @return JsonResponse
     */
    public function getByUserByHashAndSlug(string $hash, string $urlSlug): JsonResponse
    {
        $query = User::whereHas(
            'profile',
            function ($query) use ($hash) {
                $query->where('encodeUrlCode', $hash);
            }
        );

        if ($query->count() === 0) {
            return response()
                ->json(['message' => 'User not Found'])
                ->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
        }

        if ($query->count() > 1) {
            $query->whereHas(
                'profile',
                function ($query) use ($hash, $urlSlug) {
                    $query->where('encodeUrlCode', $hash)
                        ->where('urlSlug', $urlSlug);
                }
            );
        }

        $user = $query->with(request()->get('includes', []))->first();

        if (empty($user)) {
            return response()
                ->json(['message' => 'User not Found'])
                ->setStatusCode(ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()
            ->json(UserResource::make($user))
            ->setStatusCode(ResponseAlias::HTTP_OK);

    }//end getByUserByHashAndSlug()

}//end class

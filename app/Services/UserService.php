<?php

namespace App\Services;

use App\Helpers\UserHelper;
use App\Models\Form\FormFieldset;
use App\Models\Form\FormFieldsetGroup;
use App\Models\Form\Response;
use App\Models\User\Role;
use App\Models\User;
use App\Models\User\UserProfile;
use App\Models\User\UserRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class UserService
 *
 * @category Services
 * @package  Services\Okta
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserService
{


    /**
     * @param  array $userData
     * @return User
     */
    public function createUser(array $userData=[]): User
    {
        /***
         * @var User $user
         */
        return User::query()
        ->create(
            [
                'email'     => Arr::get($userData, 'email'),
                'password'  => Hash::make(Arr::get($userData, 'password', Str::random('10'))),
                'oldUserId' => UserHelper::getOldUserId(),
            ]
        );

    }//end createUser()


    /**
     * @param  User  $user
     * @param  array $userData
     * @return Model
     */
    public function createProfile(User $user, array $userData): Model
    {
        $profileData = [
            'userId'    => $user->id,
            'firstName' => Arr::get($userData, 'firstName'),
            'lastName'  => Arr::get($userData, 'lastName'),
            'urlSlug'   => UserHelper::createUniqueUserSlug(Arr::get($userData, 'firstName'), Arr::get($userData, 'lastName')),
        ];

        if (Arr::get($userData, 'birthdate')) {
            $profileData['birthdate'] = Arr::get($userData, 'birthdate');
        }

        /**
         *
         *
         * @var UserProfile $userProfile
         */

        return UserProfile::query()->create($profileData);

    }//end createProfile()


    /**
     * CreateRole
     *
     * @param User  $user
     * @param Role  $role
     * @param mixed $relationalEntityData
     *
     * @return void
     */
    public function createRole(User $user, Role $role, mixed $relationalEntityData=[]): void
    {
        UserRole::query()->create(
            [
                'userId'       => $user->id,
                'roleId'       => $role->id,
                'roleableId'   => Arr::get($relationalEntityData, 'roleableId'),
                'roleableType' => Arr::get($relationalEntityData, 'roleableType'),
            ]
        );

    }//end createRole()


    /**
     * GetUserFieldResponse
     *
     * @param  User $user
     * @return Collection
     */
    public function getUserFieldResponse(User $user): Collection
    {
        $formFieldset = (new FormFieldset)->ofResponses()
            ->where('formFieldsetGroupResponses.userId', $user->id)
            ->select(['formFieldset.id', 'formFieldset.name', 'formFieldset.label', 'formFieldset.sort', 'formFieldset.formId'])
            ->groupBy('formFieldset.id')
            ->orderBy('formFieldset.sort')
            ->get();

        return $formFieldset->map(
            function ($fFieldset) use ($user) {
                $fQuery = FormFieldsetGroup::query()
                    ->select(['formFieldsetGroupResponses.id', 'formFieldsetGroups.name', 'formFieldsetGroups.label', 'formFieldsetGroups.isContinuous', 'formFieldsetGroups.sort'])
                    ->join('formFieldsetGroupResponses', 'formFieldsetGroupResponses.formFieldsetGroupId', '=', 'formFieldsetGroups.id')
                    ->join('responses', 'responses.formFieldsetGroupResponseId', '=', 'formFieldsetGroupResponses.id')
                    ->where('formFieldsetGroups.formFieldsetId', $fFieldset->id)
                    ->where('formFieldsetGroupResponses.userId', $user->id)
                    ->whereNull('formFieldsetGroupResponses.deletedAt')
                    ->groupBy('formFieldsetGroupResponses.id')
                    ->orderBy('sort');
                $fFieldset->formFieldsetGroup = $fQuery->get()->map(
                    function ($ffgr) {
                        $ffgr->responses = Response::query()
                            ->select(['responses.id', 'responses.value', 'responses.questionId'])
                            ->join('formFieldsetGroupResponses', 'formFieldsetGroupResponses.id', 'responses.formFieldsetGroupResponseId')
                            ->where('formFieldsetGroupResponses.id', $ffgr->id)
                            ->whereNull('formFieldsetGroupResponses.deletedAt')
                            ->orderBy('formFieldsetGroupResponses.createdAt', 'ASC')
                            ->get();
                        return $ffgr;
                    }
                );
                return $fFieldset;
            }
        );

    }//end getUserFieldResponse()


}//end class

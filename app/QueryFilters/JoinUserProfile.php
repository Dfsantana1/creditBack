<?php

namespace App\QueryFilters;


use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class JoinUserProfile
 *
 * @category QueryFilters
 * @package  App\QueryFilters

 */
class JoinUserProfile
{


    /**
     * Handle Pagination Pipeline
     *
     * @param  $request
     * @param  Closure $next
     * @return Builder
     */
    public function handle($request, Closure $next): Builder
    {
        $builder = $next($request);
        // Join to make searchable
        $builder
            ->select(
                [
                    'users.*',
                    'userProfiles.firstName',
                    'userProfiles.lastName',
                    'userProfiles.preferredName',
                ]
            )
            ->join('userProfiles', 'userProfiles.userId', 'users.id');

        if (request()->has('q')) {
            $q = request()->get('q');
            $builder->where(
                function ($query) use ($q) {
                    $query->whereRaw('userProfiles.firstName LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.lastName LIKE ?', "%{$q}%")
                        ->orWhereRaw('CONCAT(userProfiles.firstName, \' \', userProfiles.lastName) LIKE ?', "%{$q}%")
                        ->orWhereRaw('users.email LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.preferredName LIKE ?', "%{$q}%");
                }
            );
        }

        if (request()->boolean('filters.archivedInd.0')) {
            $builder->where(
                function ($query) {
                    $query->whereNotNull('userProfiles.archivedAt')
                        ->orWhereNotNull('userProfiles.deletedAt');
                }
            );
        } else {
            $builder->whereNull('userProfiles.deletedAt')
                ->whereNull('userProfiles.archivedAt');
        }

        if (request()->has('filters.confirmedEmailInd')) {
            $builder->whereNotNull('emailConfirmedAt');
        }

        if (request()->has('filters.email')) {
            $builder->where('email', request()->input('filters.email'));
        }

        if (request()->has('filters.roles')) {
            $builder->join('userRoles', 'users.id', 'userRoles.userId')
                ->distinct()
                ->whereNull('userRoles.deletedAt');
        }

        if (request()->has('filters.roles')) {
            $builder->join('roles', 'roles.id', 'userRoles.roleId')
                ->whereIn('roles.name', request()->input('filters.roles'));
        }

        return $builder;

    }//end handle()


}//end class

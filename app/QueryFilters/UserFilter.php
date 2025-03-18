<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class Filter
 *
 * @category   QueryFilters
 * @package    App\QueryFilters
 * @author     Mauricio Tovar <tmauricio80@gmail.com>
 * @license    https://opensource.org/licenses/MIT MIT License
 * @link       
 * @deprecated use JoinUserProfile instead
 */
class UserFilter
{


    /**
     * Handle Filter
     *
     * @param  $request
     * @param  Closure $next
     * @return Builder
     */
    public function handle($request, Closure $next): Builder
    {
        $builder = $next($request);

        $builder->join('userRoles', 'users.id', 'userRoles.userId')
            ->join('roles', 'roles.id', 'userRoles.roleId')
            ->whereNull('userRoles.deletedAt');

        if (request()->boolean('filters.archivedInd.0')) {
            $builder->join('userProfiles AS up2', 'users.id', 'up2.userId')
                ->whereNotNull('up2.archivedAt');
        } else if (request()->has('filters.archivedInd.0')) {
            $builder->join('userProfiles AS up2', 'users.id', 'up2.userId')
                ->whereNull('up2.archivedAt');
        }

        if (request()->has('filters.confirmedEmailInd')) {
            $builder->whereNotNull('emailConfirmedAt');
        }

        if (request()->has('filters.email')) {
            $builder->where('email', request()->input('filters.email'));
        }

        if (request()->has('filters.roles')) {
            $builder->whereIn('roles.name', request()->input('filters.roles'));
        }

        // Join to make searchable
        return $builder;

    }//end handle()


}//end class

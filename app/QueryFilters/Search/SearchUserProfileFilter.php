<?php

namespace App\QueryFilters\Search;

use App\Enums\QuestionReferenceSearchEnum;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class SearchUserProfileFilter
 *
 * @category QueryFilters
 * @package  App\QueryFilters\Search
 * @author   CJ Vargas <carlos.vargas@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SearchUserProfileFilter
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

        if (request()->has('q')) {
            $q = request()->get('q');
            $builder->where(
                function ($query) use ($q) {
                    $query->whereRaw('userProfiles.firstName LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.lastName LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.code LIKE ?', "%{$q}%")
                        ->orWhereRaw('userProfiles.preferredName LIKE ?', "%{$q}%");
                }
            );
        }

        return $builder;

    }//end handle()


}//end class

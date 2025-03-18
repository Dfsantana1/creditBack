<?php

namespace App\QueryFilters;


use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class Pagination
 *
 * @category QueryFilters
 * @package  App\QueryFilters

 */
class Pagination
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
        // Sort & Direction
        $builder->orderBy(request()->input('orderBy', 'id'), request()->input('direction', 'ASC'));
        // Offset
        $builder->offset(request()->input('offset', 0));
        // Return
        return $builder;

    }//end handle()


}//end class

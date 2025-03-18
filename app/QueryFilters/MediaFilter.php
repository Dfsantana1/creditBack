<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

/**
 * Class MediaFilter
 *
 * @category QueryFilters
 * @package  App\QueryFilters

 */
class MediaFilter
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
        $builder->whereNull('media.parentId');
        if (request()->has('filters.sources')) {
            $builder->whereIn('source', request()->input('filters.sources'));
        }

        if (request()->has('filters.extensions')) {
            $builder->whereIn('extension', request()->input('filters.extensions'));
        }

        if (request()->has('filters.types')) {
            $builder->whereRaw(' UPPER(type) IN (?) ', request()->input('filters.types'));
        }

        if (request()->has('filters.userTags')) {
            $builder->join('mediaUserTags as mut', 'media.id', 'mut.mediaId')
                ->whereIn('mut.userId', request()->input('filters.userTags'))
                ->select(['media.*']);
        }

        // Join to make searchable
        return $builder;

    }//end handle()


}//end class

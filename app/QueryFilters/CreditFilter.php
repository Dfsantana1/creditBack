<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CreditFilter
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

        if (request()->has('filters.credits')) {
            $builder->whereIn('creditId', request()->input('filters.credits'));
        }

        return $builder;
    }
}

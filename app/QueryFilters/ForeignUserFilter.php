<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ForeignUserFilter
{

    public function handle($request, Closure $next): Builder
    {
        $builder = $next($request);
		if (request()->has('filters.users')) {
			$builder->where('userId', request()->input('filters.users'));
		}
        // Join to make searchable
        return $builder;

    }//end handle()
}//end class

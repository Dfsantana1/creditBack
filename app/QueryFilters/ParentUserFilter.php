<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\Builder;


class ParentUserFilter
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
		if (request()->has('filters.users')) {
			$builder->whereIn('userId', request()->input('filters.users'));;
		}

		// Join to make searchable
		return $builder;
	} //end handle()


}//end class

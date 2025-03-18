<?php

namespace App\QueryFilters\Pagination;


use App\Enums\RecordingTypeEnum;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

/**
 * Class Pagination
 *
 * @category QueryFilters
 * @package  App\Http\Controllers\User
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserPagination
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
        $orderDirection = request()->input('direction', 'ASC');
        $orderBy = request()->input('orderBy', 'id');
    
        if ($orderBy === 'getTotalPurchaseValueAttribute') {
            $builder->leftJoin('payments', 'payments.userId', '=', 'users.id');
            $builder->select('users.*', DB::raw('SUM(payments.value) as total_purchase_value'));
            $builder->groupBy('users.id');
            $builder->orderBy('total_purchase_value', $orderDirection);
        } else {
            // Ordenar por el campo predeterminado (por ejemplo, 'id')
            $builder->orderBy($orderBy, $orderDirection);
        }
    
        // Devolver el constructor de la consulta
        return $builder;
    }
    


}//end class

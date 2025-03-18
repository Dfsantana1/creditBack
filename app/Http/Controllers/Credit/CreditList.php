<?php
declare(strict_types=1);

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\Credit\CreditResource;
use App\Http\Resources\CreditResource as ResourcesCreditResource;
use App\Models\Credit;
use App\Models\Credit\Credit as CreditCredit;
use App\QueryFilters\Pagination;
use App\QueryFilters\Pagination\CreditPagination;
use App\QueryFilters\ParentUserFilter;
use Illuminate\Contracts\Container\Container;

/**
 * Class CreditList
 *
 * @extends  ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Credit
 */
class CreditList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = CreditCredit::class;

    /**
     * @var string
     */
    public string $resourceClass = ResourcesCreditResource::class;

    /**
     * @var string
     */
    public string $requestClass = PaginationRequest::class;


    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->filters = [
            ParentUserFilter::class,
            Pagination::class,
        ];
        parent::__construct($container);
    }
}

<?php
declare(strict_types=1);

namespace App\Http\Controllers\Quota;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\QuotaResource;
use App\Models\Quota\Quota;
use App\QueryFilters\CreditFilter;
use Illuminate\Contracts\Container\Container;

/**
 * Class QuotaList
 *
 * @extends  ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Quota
 */
class QuotaList extends ScoutList
{
    /**
     * @var string
     */
    public string $modelClass = Quota::class;

    /**
     * @var string
     */
    public string $resourceClass = QuotaResource::class;

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
            CreditFilter::class, // Filtra cuotas por usuario (opcional)
        ];
        parent::__construct($container);
    }
}

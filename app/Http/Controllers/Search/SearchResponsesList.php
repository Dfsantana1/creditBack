<?php
declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\Search\SearchUserQAResource;
use App\Models\Form\Response;
use App\QueryFilters\Pagination;
use App\QueryFilters\Search\SearchResponse;
use Illuminate\Contracts\Container\Container;

/**
 * Class SearchResponsesList
 *
 * @extends  ScoutList ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Search
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SearchResponsesList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = Response::class;

    /**
     * @var string
     */
    public string $resourceClass = SearchUserQAResource::class;

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
            Pagination::class,
            SearchResponse::class,
        ];

        parent::__construct($container);

    }//end __construct()


}//end class

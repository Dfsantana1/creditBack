<?php
declare(strict_types=1);

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Models\User;
use App\QueryFilters\Pagination;
use App\QueryFilters\Search\SearchUserProfileFilter;
use Illuminate\Contracts\Container\Container;

/**
 * Class SearchList
 *
 * @extends  ScoutList ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Search
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SearchList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = '';

    /**
     * @var string
     */
    public string $resourceClass = '';

    /**
     * @var string
     */
    public string $requestClass = PaginationRequest::class;


    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->filters = [Pagination::class];

        if (request()->entity === 'people') {
            $this->filters[] = SearchUserProfileFilter::class;
        }

        $this->modelClass = match (request()->entity) {
            default => User::class,
        };

        parent::__construct($container);

    }//end __construct()


}//end class

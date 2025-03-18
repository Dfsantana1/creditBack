<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\MediaEntityResource;
use App\Models\MediaEntity\MediaEntity;
use App\QueryFilters\MediaEntityFilter;
use App\QueryFilters\Pagination;
use Illuminate\Contracts\Container\Container;

/**
 * Class MediaEntityList
 *
 * @extends  ScoutList ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = MediaEntity::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaEntityResource::class;

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
            MediaEntityFilter::class,
        ];
        parent::__construct($container);

    }//end __construct()


}//end class

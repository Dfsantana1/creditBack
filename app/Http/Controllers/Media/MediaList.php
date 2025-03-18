<?php
declare(strict_types=1);

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\MediaCompleteResource;
use App\Models\Media\Media;
use App\QueryFilters\MediaFilter;
use App\QueryFilters\Pagination;
use Illuminate\Contracts\Container\Container;

/**
 * Class MediaList
 *
 * @extends  ScoutList ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Region
 * @author   Catalina Cardona <itcataca@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = Media::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaCompleteResource::class;

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
            MediaFilter::class,
        ];
        parent::__construct($container);

    }//end __construct()


}//end class

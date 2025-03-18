<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\ScoutList;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\User\UserMinResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\QueryFilters\JoinUserProfile;
use App\QueryFilters\Pagination\UserPagination;
use Illuminate\Contracts\Container\Container;

/**
 * Class UserList
 *
 * @extends  ScoutList ScoutList
 * @category Controllers
 * @package  App\Http\Controllers\Region
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserList extends ScoutList
{

    /**
     * @var string
     */
    public string $modelClass = User::class;

    /**
     * @var string
     */
    public string $resourceClass = UserResource::class;

    /**
     * @var string
     */
    public string $requestClass = PaginationRequest::class;


    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        if (in_array('secure', request()->segments())) {
            $this->resourceClass = UserMinResource::class;
        }

        $this->filters = [
            UserPagination::class,
            JoinUserProfile::class,
        ];
        parent::__construct($container);

    }//end __construct()


}//end class

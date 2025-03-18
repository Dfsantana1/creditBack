<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\BaseDetail;
use App\Http\Resources\User\UserMinResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Contracts\Container\Container;

/**
 * Class UserDetail
 *
 * @extends  BaseDetail BaseDetail
 * @category Controllers
 * @package  App\Http\Controllers\User
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserDetail extends BaseDetail
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
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        if (in_array('secure', request()->segments())) {
            $this->resourceClass = UserMinResource::class;
        }

        parent::__construct($container);

    }//end __construct()


}//end class

<?php
declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Base\BaseDelete;
use App\Models\User;
use App\Models\User\UserProfile;
use Carbon\Carbon;

/**
 * Class UserDelete
 *
 * @extends  BaseDelete BaseDelete
 * @category Controllers
 * @package  App\Http\Controllers\Region
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class UserDelete extends BaseDelete
{

    /**
     * @var string
     */
    public string $modelClass = User::class;

}//end class

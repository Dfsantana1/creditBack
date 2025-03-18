<?php
declare(strict_types=1);

namespace App\Models\User;

use App\Traits\UuidTrait;
use Database\Factories\UserRoleFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * UserRole Class
 *
 * @category      User
 * @package       App\Models
 * @property      string $id
 * @property      string $userId
 * @property      string $roleId
 * @property      string $roleableType
 * @property      string $roleableId
 * @property      Carbon $createdAt
 * @property      Carbon $updatedAt
 * @property      Carbon $deletedAt
 * @property-read User $user
 * @property-read Role $role
 * @author        Mauricio Tovar <tmauricio80@gmail.com>
 * @license       https://opensource.org/licenses/MIT MIT License
 * @link          
 */
class UserRole extends Model
{

    use HasFactory, SoftDeletes, UuidTrait;

    /**
     * @var string Rename created_at
     */
    const CREATED_AT = 'createdAt';
    /**
     * @var string Rename updated_at
     */
    const UPDATED_AT = 'updatedAt';
    /**
     * @var string Rename deleted_at
     */
    const DELETED_AT = 'deletedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * Rename Default Table Name
     *
     * @var string
     */
    protected $table = 'userRoles';


    /**
     * User Factory
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserRoleFactory::new();

    }//end newFactory()


}//end class

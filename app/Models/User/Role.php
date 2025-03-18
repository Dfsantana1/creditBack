<?php
declare(strict_types=1);

namespace App\Models\User;

use App\Enums\User\UserRoleEnum;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class Role
 *
 * @category Role
 * @package  App\Models
 * @property string $id
 * @property string $name

 */
class Role extends Model
{
    use HasFactory, UuidTrait;

    /**
     * No User Timestamp
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Mass Assignable
     *
     * @var string[]
     */
    protected $fillable = ['name'];

    /**
     * Fields hidden
     *
     * @var string[]
     */
    protected $hidden = ['pivot'];


    //------------------------------------------------------
    // SCOPES
    //------------------------------------------------------


    /**
     * @param  $query
     * @return Builder
     */
    public static function admin($query): Builder
    {
        return $query->where('name', UserRoleEnum::ADMIN->name);

    }//end admin()


    /**
     * @param  $query
     * @return Builder
     */
    public function corporateAdmin($query): Builder
    {
        return $query->where('name', UserRoleEnum::CORPORATION_ADMIN->name);

    }//end corporateAdmin()


}//end class

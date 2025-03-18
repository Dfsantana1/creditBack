<?php

namespace App\Models\OktaRequests;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Scout\Searchable;

/**
 * Class OktaRequest
 *
 * @category Okta
 * @package  App\Models
 * @property string $id
 * @property string $request
 * @property string $token
 * @property string $userId
 * @property string $actionType
 * @property string $ipAddress
 * @property string $requestHeaders
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Carbon $deletedAt
 * @property Carbon $loggedOutAt

 */
class OktaRequest extends Model
{
    use UuidTrait, Searchable, SoftDeletes;

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
     * Rename Default Table Name
     *
     * @var string
     */
    protected $table = 'OktaRequests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * $casts
     *
     * @var array
     */
    protected $casts = ['token' => 'string'];

    //------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------


    /**
     * Get User
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);

    }//end user()


}//end class

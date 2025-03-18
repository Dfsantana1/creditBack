<?php
declare(strict_types=1);

namespace App\Models\EmailTracking;

use App\Models\User;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * EmailTracking Class
 *
 * @extends  Model
 * @category EmailTracking
 * @package  App\Models
 * @property int $id
 * @property string $emailId
 * @property string $sender
 * @property string $receiver
 * @property string $userId
 * @property string $body
 * @property string $status
 * @property string $detail
 * @property string $active
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Carbon $deletedAt
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class EmailTracking extends Model
{
    use SoftDeletes, UuidTrait;

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
     * @var string
     */
    protected $table = 'emailTracking';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Fields hidden
     *
     * @var string[]
     */
    protected $hidden = [];

    /**
     * @var string[]
     */
    protected $casts = ['detail' => 'json'];


    /**
     * Get user relation
     *
     * @return BelongsTo
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');

    }//end user()


}//end class

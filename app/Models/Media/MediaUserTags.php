<?php
declare(strict_types=1);

namespace App\Models\Media;

use App\Models\User;
use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Media Class
 *
 * @category      Media
 * @package       App\Models\Media
 * @property      string $id
 * @property      int $page
 * @property      string $note
 * @property      string $url
 * @property      string $userId
 * @property      int $mediaId
 * @property      Carbon $createdAt
 * @property      Carbon $updatedAt
 * @property      Carbon $deletedAt
 * @property-read Media $media
 * @property-read User $user
 * @author        Mauricio Tovar <tmauricio80@gmail.com>
 * @license       https://opensource.org/licenses/MIT MIT License
 * @link          
 */
class MediaUserTags extends Model
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
     * Rename Default Name Table
     *
     * @var string
     */
    protected $table = 'mediaUserTags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string, string>
     */
    protected $hidden = [
        'updatedAt',
        'createdAt',
        'deletedAt',
    ];

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

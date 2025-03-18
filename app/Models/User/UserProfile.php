<?php
declare(strict_types=1);

namespace App\Models\User;

use App\Models\User;
use App\Traits\UuidTrait;
use App\Models\Media\Media;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserProfileFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class UserProfile
 *
 * @category User
 * @package  App\Models
 * @property string $id
 * @property string $userId
 * @property string $firstName
 * @property string $lastName
 * @property string $code
 * @property string $urlSlug
 * @property string $encodeUrlCode
 * @property string $crmId
 * @property string $building
 * @property string $about
 * @property string $birthdate
 * @property string $moveInDate
 * @property string $moveOutDate
 * @property string $mediaId
 * @property string $preferredName
 * @property Carbon $nextInterviewDt
 * @property Carbon $archivedAt
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property string $PCCODocumentId
 * @property string $PCCPatientId
 * @property string $PCCPatientUUId
 * @property Carbon $sentToPCCAt

 */
class UserProfile extends Model
{

    use HasFactory, UuidTrait;

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
     * Rename Default Name Table
     *
     * @var string
     */
    protected $table = 'userProfiles';

    //------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------


    /**
     * Get User Profile
     *
     * @return BelongsTo
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'mediaId');

    }//end media()


    /**
     * UserProfile Factory
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserProfileFactory::new();

    }//end newFactory()



    /**
     * Get user relation
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');

    }//end user()


}//end class

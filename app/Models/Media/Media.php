<?php
declare(strict_types=1);

namespace App\Models\Media;

use App\Models\User;
use App\Traits\UuidTrait;
use App\Traits\UploadTrait;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Illuminate\Support\Carbon;
use App\Services\TranscribeService;
use Illuminate\Support\Facades\Log;
use Database\Factories\MediaFactory;
use App\Models\MediaEntity\MediaEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Media Class
 *
 * @category      Media
 * @package       App\Models
 * @property      string $id
 * @property      string $name
 * @property      string $description
 * @property      string $fileType
 * @property      string $type
 * @property      string $extension
 * @property      int $width
 * @property      int $height
 * @property      string $size
 * @property      string $reference
 * @property      string $source
 * @property      string $bucketName
 * @property      string $resource
 * @property      string $url
 * @property      string $mediableType
 * @property      int $mediableId
 * @property      int $uploadByUserId
 * @property      int $parentId
 * @property      Carbon $archivedInGalleryAt
 * @property      Carbon $dueAt
 * @property      Carbon $createdAt
 * @property      Carbon $updatedAt
 * @property      Carbon $deletedAt
 * @property-read Media $imageParent
 * @property-read User $uploadedByUser
 * @method        static find($mediaIa)
 * @author        Mauricio Tovar <tmauricio80@gmail.com>
 * @license       https://opensource.org/licenses/MIT MIT License
 * @link          
 */
class Media extends Model
{
    use HasFactory, SoftDeletes, UuidTrait, Searchable, UploadTrait;
    // DONE May Delete

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
     * Fields hidden
     *
     * @var string[]
     */
    protected $hidden = [
        'mediableId',
        'mediableType',
        'updatedAt',
        'createdAt',
        'deletedAt',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * InsightCreate a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return MediaFactory::new();

    }//end newFactory()


    /**
     * Overrides Searchable fields
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
        ];

    }//end toSearchableArray()


    //------------------------------------------------------
    // RELATIONSHIPS
    //------------------------------------------------------


    /**
     * Get All Child
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Media::class, 'parentId');

    }//end children()


    /**
     * Get Users Tags
     *
     * @return HasMany
     */
    public function userTags(): HasMany
    {
        return $this->hasMany(MediaUserTags::class, 'mediaId')
            ->join('userProfiles', 'mediaUserTags.userId', '=', 'userProfiles.userId')
            ->where('mediaUserTags.mediaId', $this->getAttribute('id'))
            ->select(['mediaUserTags.id AS mediaUserTagId', 'mediaUserTags.page', 'userProfiles.*']);

    }//end userTags()



    /**
     * Get All Media Entities
     *
     * @return HasMany
     */
    public function mediaEntities(): HasMany
    {
        return $this->hasMany(MediaEntity::class, 'mediaId', 'id');

    }//end mediaEntities()


    //------------------------------------------------------
    // FUNCTIONS
    //------------------------------------------------------


    /**
     * Process Uploaded AWS Url
     *
     * @param  Request $request
     * @return Media
     * @throws \Exception
     */
    public static function processUploadedAWSUrl(Request $request): Media
    {
        $values = ImageHelper::getMediaValuesForUrl($request->input('url'));
        /**
        * @var Media $media
        */
        $media = Media::query()->create($values);
        $media->mediableId   = $request->input('userId');
        $media->mediableType = User::class;
        $media->save();

        return $media;

    }//end processUploadedAWSUrl()


}//end class

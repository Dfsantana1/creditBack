<?php

namespace App\Models\MediaEntity;

use App\Traits\UuidTrait;
use App\Models\Media\Media;
use Laravel\Scout\Searchable;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * MediaEntity Class
 *
 * @category MediaEntity
 * @package  App\Models\MediaEntity
 * @property string $id
 * @property string $mediaId
 * @property string $entityId
 * @property string $entityType
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 * @property Carbon $deletedAt
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntity extends Model
{
    use SoftDeletes, UuidTrait, Searchable;

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
    protected $table = 'mediaEntities';

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


    /**
     * Get media
     *
     * @return HasOne
     */
    public function media(): HasOne
    {
        return $this->hasOne(Media::class, 'id', 'mediaId');

    }//end media()


}//end class

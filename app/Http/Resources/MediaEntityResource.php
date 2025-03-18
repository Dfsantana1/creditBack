<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\MediaEntityHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MediaEntityResource
 *
 * @category Resources
 * @package  App\Http\Resources
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityResource extends JsonResource
{

    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var boolean
     */
    public bool $preserveKeys = true;


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->resource->id,
            'mediaId'    => $this->resource->mediaId,
            'entityId'   => $this->resource->entityId,
            'entityType' => MediaEntityHelper::getEntityType($this->resource->entityType),
            'media'      => MediaResource::make($this->resource->media),
        ];

    }//end toArray()


}//end class

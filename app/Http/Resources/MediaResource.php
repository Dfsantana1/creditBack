<?php
declare(strict_types=1);

namespace App\Http\Resources;

use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MediaResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class MediaResource extends JsonResource
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
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'url'         => $this->resource->url,
            'width'       => $this->resource->width,
            'height'      => $this->resource->height,
            'source'      => $this->resource->source,
			'bytesSize'   => $this->resource->bytesSize,
			'documentId'  => $this->resource->documentId,
            'size'        => $this->resource->size,
            'type'        => strtoupper($this->resource->type),
            'uploadDate'  => $this->resource->createdAt,
            'children'    => MediaResource::collection($this->resource->children),
            'mediaEntity' => MediaEntityResource::collection($this->whenLoaded('mediaEntity')),
        ];

    }//end toArray()


}//end class

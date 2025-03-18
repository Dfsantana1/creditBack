<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class MediaMinResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class MediaMinResource extends JsonResource
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
     * @param Request $request // Request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->resource->id,
            'name'       => $this->resource->name,
            'url'        => $this->resource->url,
            'size'       => $this->resource->size,
			'bytesSize'  => $this->resource->bytesSize,
			'documentId'  => $this->resource->documentId,
            'width'      => $this->resource->width,
            'height'     => $this->resource->height,
            'uploadDate' => $this->resource->createdAt,
            'children'   => MediaMinResource::collection($this->resource->children),
        ];

    }//end toArray()


}//end class

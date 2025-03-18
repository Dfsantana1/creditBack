<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ModelBot\ModelBotResource;

/**
 * Class MediaResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class MediaCompleteResource extends JsonResource
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
            'id'                  => $this->resource->id,
            'name'                => $this->resource->name,
            'description'         => $this->resource->description,
            'url'                 => $this->resource->url,
            'width'               => $this->resource->width,
            'height'              => $this->resource->height,
            'source'              => $this->resource->source,
			'bytesSize'      	  => $this->resource->bytesSize,
			'documentId'  		  => $this->resource->documentId,
            'extension'           => $this->resource->extension,
            'dueAt'               => $this->resource->dueAt,
            'createdAt'           => $this->resource->createdAt,
			'parentEntityType'    =>  $this->resource->mediableType,
            'type'                => strtoupper($this->resource->type),
            'children'            => MediaResource::collection($this->resource->children),
            'userTags'            => $this->resource->userTags,
            'mediaEntities'       => MediaEntityResource::collection($this->whenLoaded('mediaEntities')),
        ];

    }//end toArray()


}//end class

<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserProfileResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class UserProfileResource extends JsonResource
{


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
            'id'               => $this->resource->id,
            'code'             => $this->resource->code,
            'nickname'         => $this->resource->nickname,
            'emailStatus'      => $this->resource->emailStatus,
            'gender'           => $this->resource->gender,
            'building'         => $this->resource->building,
            'about'            => $this->resource->about,
            'phoneNumber'      => $this->resource->phoneNumber,
            'media'            => $this->resource->media,
            'preferredName'    => $this->resource->preferredName,
            'archivedAt'       => $this->resource->archivedAt,
            'publicProfileUrl' => $this->resource->publicProfileUrl,
        ];

    }//end toArray()


}//end class

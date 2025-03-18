<?php

namespace App\Http\Resources\Search;

use App\Http\Resources\User\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SearchUserResource
 *
 * @category Resource
 * @package  App\Http\Resources
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SearchUserResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->resource->id,
            'firstName'     => ($this->resource->user) ? $this->resource->user->profile?->firstName : null,
            'lastName'      => ($this->resource->user) ? $this->resource->user->profile?->lastName : null,
            'email'         => $this->resource->email,
            'profile'       => UserProfileResource::make($this->resource->user?->profile),
        ];

    }//end toArray()


}//end class

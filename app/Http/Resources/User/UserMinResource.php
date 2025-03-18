<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Http\Resources\CareTypeResource;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserMinResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class UserMinResource extends JsonResource
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
            'id'          => $this->resource->id,
            'email'       => $this->resource->email,
            'firstName'   => $this->resource->profile?->firstName,
            'lastName'    => $this->resource->profile?->lastName,
            'name'        => $this->resource->profile?->firstName.' '.$this->resource->profile?->lastName,
            'birthday'    => $this->resource->birthdate,
            'createdAt'   => $this->resource->createdAt->format('Y-m-d H:i:s'),
            'roles'       => RoleResource::collection($this->resource->roles),
        ];

    }//end toArray()


}//end class

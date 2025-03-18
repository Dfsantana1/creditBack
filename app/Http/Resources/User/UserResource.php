<?php
declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\User\UserRoleEnum;
use App\Http\Resources\StoryResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\InterviewResource;
use App\Http\Resources\RecordingResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class UserResource extends JsonResource
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
        $ary = [
            'id'                => $this->resource->id,
            'firstName'         => ($this->resource->profile) ? $this->resource->profile->firstName : null,
            'lastName'          => ($this->resource->profile) ? $this->resource->profile->lastName : null,
            'name'              => ($this->resource->profile) ? $this->resource->profile->firstName.' '.$this->resource->profile->lastName : null,
            'email'             => $this->resource->email,
			'emailConfirmedAt'  => $this->resource->emailConfirmedAt,
            'createdAt'         => $this->resource->createdAt->format('Y-m-d H:i:s'),
            'profile'           => UserProfileResource::make($this->resource->profile),
            'roles'             => $this->resource->roles,
   ];

        return $ary;

    }//end toArray()


}//end class

<?php

namespace App\Http\Resources\Search;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class SearchResource
 *
 * @category Resource
 * @package  App\Http\Resources
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class searchResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $arr = [
            'residents' => UserResource::collection($this->resource->get('residents')),
        ];

        return $arr;

    }//end toArray()


}//end class

<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LocationResource
 *
 * @category Resources
 * @package  App\Http\Resources

 */
class LocationResource extends JsonResource
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
        $name  = (!empty($this->resource->line1)) ? trim($this->resource->line1) : null;
        $name .= (!empty($this->resource->line2)) ? ' '.trim($this->resource->line2) : null;
        $name .= (!empty($this->resource->city)) ? ' '.trim($this->resource->city) : null;
        $name .= (!empty($this->resource->state)) ? ', '.trim($this->resource->state) : null;
        $name .= (!empty($this->resource->zip)) ? ', '.trim($this->resource->zip) : null;
        $name .= (!empty($this->resource->country)) ? ' '.trim($this->resource->country) : null;

        return [
            'id'        => $this->resource->id,
            'name'      => trim($name),
            'line1'     => $this->resource->line1,
            'line2'     => $this->resource->line2,
            'city'      => $this->resource->city,
            'state'     => $this->resource->state,
            'zip'       => $this->resource->zip,
            'country'   => $this->resource->country,
            'latitude'  => $this->resource->latitude,
            'longitude' => $this->resource->longitude,
            'point'     => $this->resource->point,
        ];

    }//end toArray()


}//end class

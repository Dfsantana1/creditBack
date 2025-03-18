<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class QuotaResource
 *
 * @category Resources
 * @package  App\Http\Resources
 */
class QuotaResource extends JsonResource
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
            'id'        => $this->resource->id,
            'creditId'  => $this->resource->creditId,
            'amount'    => $this->resource->amount,
            'dueDate'   => $this->resource->dueDate,
            'status'    => $this->resource->status,
            'createdAt' => $this->resource->createdAt,
            'updatedAt' => $this->resource->updatedAt,
        ];
    }
}

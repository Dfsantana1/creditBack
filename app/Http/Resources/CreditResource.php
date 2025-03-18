<?php
declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CreditResource
 *
 * @category Resources
 * @package  App\Http\Resources
 */
class CreditResource extends JsonResource
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
            'userId'      => $this->resource->userId,
            'amount'      => $this->resource->amount,
            'installments'=> $this->resource->installments,
            'createdAt'   => $this->resource->createdAt,
            'updatedAt'   => $this->resource->updatedAt,
            'isPaid'      => $this->isPaid(),
            'quotas'      => QuotaResource::collection($this->resource->quotas)
        ];
    }
}

<?php

namespace App\Http\Controllers\Quota;

use App\Models\Quota\Quota;
use App\Http\Controllers\Base\BaseDetail;
use App\Http\Resources\QuotaResource;
use Illuminate\Contracts\Container\Container;

/**
 * Class QuotaDetail
 *
 * @extends  BaseDetail
 * @category Controllers
 * @package  App\Http\Controllers\Quota
 */
class QuotaDetail extends BaseDetail
{
    /**
     * @var string
     */
    public string $modelClass = Quota::class;

    /**
     * @var string
     */
    public string $resourceClass = QuotaResource::class;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
}

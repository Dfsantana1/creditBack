<?php

namespace App\Http\Controllers\Vendor;

use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Models\VendorProducts;
use App\Http\Resources\VendorProductsResource;
use App\Http\Requests\PaginationRequest;

use Illuminate\Contracts\Container\Container;
use App\Http\Controllers\Base\ScoutList;
class VendorProductsList extends ScoutList
{
    use ScopesTrait, UploadTrait;   

    /**
     * @var string
     */
    public string $modelClass = VendorProducts::class;

    /**
     * @var string
     */
    public string $resourceClass = VendorProductsResource::class;

    /**
     * @var string
     */
    public string $requestClass = PaginationRequest::class;

        /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->filters = [
        ];
        parent::__construct($container);

    }//end __construct()



}

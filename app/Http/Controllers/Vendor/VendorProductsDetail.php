<?php

namespace App\Http\Controllers\Vendor;

use App\Models\VendorProducts;
use App\Http\Resources\VendorProductsResource;
use App\Http\Controllers\Base\BaseDetail;

use Illuminate\Contracts\Container\Container;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
class VendorProductsDetail extends BaseDetail
{
    /**
     * @var string
     */
    public string $modelClass = VendorProducts::class;

    /**
     * @var string
     */
    public string $resourceClass = VendorProductsResource::class;


    
    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);

    }//end __construct()


}

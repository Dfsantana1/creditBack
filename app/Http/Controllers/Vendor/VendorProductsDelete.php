<?php

namespace App\Http\Controllers\Vendor;

use App\Models\VendorProducts;
use App\Http\Controllers\Base\BaseDelete;
class VendorProductsDelete  extends BaseDelete
{
 
        /**
     * @var string
     */
    public string $modelClass = VendorProducts::class;
}

<?php

namespace App\Http\Controllers\Credit;

use App\Models\Credit\Credit;
use App\Http\Controllers\Base\BaseDetail;
use App\Http\Resources\CreditResource;
use Illuminate\Contracts\Container\Container;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
class CreditDetail extends BaseDetail
{
    /**
     * @var string
     */
    public string $modelClass = Credit::class;

    /**
     * @var string
     */
    public string $resourceClass = CreditResource::class;


    
    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);

    }//end __construct()


}

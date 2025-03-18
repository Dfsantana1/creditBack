<?php

namespace App\Http\Controllers\Credit;

use App\Models\Credit\Credit;

use App\Http\Controllers\Base\BaseDelete;
class CreditDelete extends BaseDelete
{
 
        /**
     * @var string
     */
    public string $modelClass = Credit::class;
}

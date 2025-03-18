<?php

namespace App\Http\Controllers\Quota;

use App\Models\Quota\Quota;
use App\Http\Controllers\Base\BaseDelete;

/**
 * Class QuotaDelete
 *
 * @extends  BaseDelete
 * @category Controllers
 * @package  App\Http\Controllers\Quota
 */
class QuotaDelete extends BaseDelete
{
    /**
     * @var string
     */
    public string $modelClass = Quota::class;
}

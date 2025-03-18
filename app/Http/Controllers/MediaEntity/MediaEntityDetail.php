<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Http\Controllers\Base\BaseDetail;
use App\Http\Resources\MediaEntityResource;
use App\Models\MediaEntity\MediaEntity;

/**
 * Class MediaEntityDetail
 *
 * @extends  BaseDetail BaseDetail
 * @category Controllers
 * @package  App\Http\Controllers\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityDetail extends BaseDetail
{

    /**
     * @var string
     */
    public string $modelClass = MediaEntity::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaEntityResource::class;

}//end class

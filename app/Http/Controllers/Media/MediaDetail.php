<?php
declare(strict_types=1);

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Base\BaseDetail;
use App\Http\Resources\MediaCompleteResource;
use App\Models\Media\Media;

/**
 * Class MediaDetail
 *
 * @extends  BaseDetail BaseDetail
 * @category Controllers
 * @package  App\Http\Controllers\Region
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaDetail extends BaseDetail
{

    /**
     * @var string
     */
    public string $modelClass = Media::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaCompleteResource::class;

}//end class

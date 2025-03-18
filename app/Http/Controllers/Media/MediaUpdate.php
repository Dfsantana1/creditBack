<?php
declare(strict_types=1);

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Base\BaseUpdate;
use App\Http\Requests\Media\MediaUpdateRequest;
use App\Http\Resources\MediaCompleteResource;
use App\Models\Media\Media;

/**
 * Class MediaUpdate
 *
 * @extends  BaseUpdate BaseUpdate
 * @category Controllers
 * @package  App\Http\Controllers\Region
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaUpdate extends BaseUpdate
{

    /**
     * @var string
     */
    public string $modelClass = Media::class;

    /**
     * @var string
     */
    public string $resourceClass = MediaCompleteResource::class;

    /**
     * @var string
     */
    public string $requestClass = MediaUpdateRequest::class;
}//end class

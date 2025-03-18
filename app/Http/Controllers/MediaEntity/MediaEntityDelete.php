<?php
declare(strict_types=1);

namespace App\Http\Controllers\MediaEntity;

use App\Http\Controllers\Base\BaseDelete;
use App\Models\MediaEntity\MediaEntity;

/**
 * Class MediaEntityDelete
 *
 * @extends  BaseDelete BaseDelete
 * @category Controllers
 * @package  App\Http\Controllers\MediaEntity
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class MediaEntityDelete extends BaseDelete
{

    /**
     * @var string
     */
    public string $modelClass = MediaEntity::class;

}//end class

<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * ImageSizeEnum
 *
 * @category Enums
 * @package  App\Enums

 */
enum ImageSizeEnum: string
{
    case ORIGINAL  = 'ORIGINAL';
    case MEDIUM    = 'MEDIUM';
    case THUMBNAIL = 'THUMBNAIL';
    case CUSTOM    = 'CUSTOM';
}//end enum

<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * OrderStatusEnum
 *
 * @category Enums
 * @package  App\Enums

 */
enum OrderStatusEnum: string
{
    case STORE  = 'STORE';
    case DISTRIBUTION    = 'DISTRIBUTION';
    case DELIVERED = 'DELIVERED';
}//end enum

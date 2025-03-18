<?php
declare(strict_types=1);

namespace App\Enums\User;

/**
 * UserEmailStatusEnum
 *
 * @category Enums
 * @package  App\Enums

 */
enum UserEmailStatusEnum: string
{
    case DELIVERABLE   = 'DELIVERABLE';
    case UNDELIVERABLE = 'UNDELIVERABLE';
    case DO_NOT_SEND   = 'DO_NOT_SEND';
    case UNKNOWN       = 'UNKNOWN';
    case CATCH_ALL     = 'CATCH_ALL';
}//end enum

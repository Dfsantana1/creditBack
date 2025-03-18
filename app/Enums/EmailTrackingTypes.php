<?php
declare(strict_types=1);

namespace App\Enums;

/**
 * EmailTrackingTypes
 *
 * @category Enums
 * @package  App\Enums
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
enum EmailTrackingTypes: string
{
    case TRANSACTIONAL = 'TRANSACTIONAL';
    case ATTENDANCE    = 'ATTENDANCE';
    case INSIGHTS      = 'INSIGHTS';
    case BENCHMARK     = 'BENCHMARK';
    case INQUIRY       = 'INQUIRY';
    case CONFIRM_REGISTRATION = 'CONFIRM_REGISTRATION';
    case RELATIVE_INVITE      = 'RELATIVE_INVITE';
    case WELCOME_EMAIL        = 'WELCOME_EMAIL';
    case PASSWORD_FORGOT      = 'PASSWORD_FORGOT';
    case CONFIRMATION_RESET_PASSWORD = 'CONFIRMATION_RESET_PASSWORD';
}//end enum
<?php
declare(strict_types=1);

namespace App\Enums;

use App\Models\Conversation\Conversation;
use App\Models\User;

/**
 * MediaEntityEnum
 *
 * @category Enums
 * @package  App\Enums
 * @author   CJ Vargas <carlos.vargas@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
enum MediaEntityTypeEnum: string
{
    case USER         = User::class;
    case CONVERSATION = Conversation::class;
}//end enum

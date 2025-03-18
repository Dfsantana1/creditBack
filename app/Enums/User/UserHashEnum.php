<?php
declare(strict_types=1);

namespace App\Enums\User;

/**
 * UserHashEnum
 *
 * @category Enums
 * @package  App\Enums
 * @author   CJ Vargas <dsantanafernandez@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
enum UserHashEnum: int
{
    case INITIAL = 666;
    case LAST    = 999;

}//end enum

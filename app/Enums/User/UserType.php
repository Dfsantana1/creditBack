<?php
declare(strict_types=1);

namespace App\Enums\User;

/**
 *
 * @category Enums
 * @package  App\Enums
 * @method   static static OptionOne()
 * @method   static static OptionTwo()
 * @method   static static OptionThree()
 * @author   William Gomez <william.gomez712@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
enum UserType: int
{
    case OPTIONONE   = 0;
    case OPTIONTWO   = 1;
    case OPTIONTHREE = 2;
}//end enum

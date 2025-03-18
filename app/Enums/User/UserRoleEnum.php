<?php
declare(strict_types=1);

namespace App\Enums\User;


/**
 * UserRoleEnum
 *
 * INCLUDE WITH SINGULAR (ENTITY) _ ROLE
 *
 * @category Enums
 * @package  App\Enums

 */
enum UserRoleEnum: string
{
    case ADMIN = 'ADMIN';
	case SINGLE_USER = 'SINGLE_USER';

    case WHOLESALE_USER = 'WHOLESALE_USER';

    case SALE_USER = 'SALE_USER';

    case MARKETER_USER = 'MARKETER_USER';
}//end enum

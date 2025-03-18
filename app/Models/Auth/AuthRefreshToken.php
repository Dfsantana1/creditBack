<?php

namespace App\Models\Auth;

use Laravel\Passport\RefreshToken;

/**
 * Class AuthRefreshToken
 *
 * @category Auth
 * @package  App\Models

 */
class AuthRefreshToken extends RefreshToken
{

    /**
     * Override Table Name
     *
     * @var string
     */
    public $table = 'OAuthRefreshTokens';

}//end class

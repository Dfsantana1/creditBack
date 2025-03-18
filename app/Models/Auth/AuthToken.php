<?php

namespace App\Models\Auth;

use Laravel\Passport\Token;

/**
 * Class AuthToken
 *
 * @category Auth
 * @package  App\Models

 */
class AuthToken extends Token
{

    /**
     * Override Table Name
     *
     * @var string
     */
    public $table = 'OAuthAccessTokens';

}//end class

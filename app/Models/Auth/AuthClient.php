<?php

namespace App\Models\Auth;

use Laravel\Passport\Client;

/**
 * Class AuthClient
 *
 * @category Auth
 * @package  App\Models

 */
class AuthClient extends Client
{

    /**
     * Override Table Name
     *
     * @var string
     */
    public $table = 'OAuthClients';

}//end class

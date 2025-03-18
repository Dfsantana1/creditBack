<?php

namespace App\Models\Auth;

use Laravel\Passport\PersonalAccessClient;

/**
 * Class AuthPersonalAccessClient
 *
 * @category Auth
 * @package  App\Models

 */
class AuthPersonalAccessClient extends PersonalAccessClient
{

    /**
     * Override Table Name
     *
     * @var string
     */
    public $table = 'OAuthPersonalAccessClients';


}//end class

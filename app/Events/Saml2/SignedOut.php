<?php

namespace App\Events\Saml2;

use Slides\Saml2\Auth;
use Slides\Saml2\Saml2User;

/**
 * Class SignedOut
 *
 * @category Controller
 * @package  App\Events\Saml2
 * @author   Jignesh Parmar <jignesh.parmar@tsolife.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     
 */
class SignedOut extends \Slides\Saml2\Events\SignedOut
{

    /**
     * The signed-up user.
     *
     * @var Saml2User
     */
    public $user;

    /**
     * The authentication handler.
     *
     * @var Auth
     */
    public $auth;


    /**
     * LoggedIn constructor.
     *
     * @param Saml2User $user
     * @param Auth      $auth
     */
    public function __construct(Saml2User $user, Auth $auth)
    {
        $this->user = $user;
        $this->auth = $auth;

    }//end __construct()


    /**
     * Get the authentication handler for a SAML sign in attempt
     *
     * @return Auth The authentication handler for the SignedIn event
     */
    public function getAuth(): Auth
    {
        return $this->auth;

    }//end getAuth()


    /**
     * Get the user represented in the SAML sign in attempt
     *
     * @return Saml2User The user for the SignedIn event
     */
    public function getSaml2User(): Saml2User
    {
        return $this->user;

    }//end getSaml2User()


}//end class

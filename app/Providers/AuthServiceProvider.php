<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

/**
 * Class AuthServiceProvider
 *
 * @category Providers
 * @package  App\Providers

 */
class AuthServiceProvider extends ServiceProvider
{

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Passport::loadKeysFrom(storage_path());
        Passport::tokensExpireIn(now()->addMinutes(30));
        Passport::refreshTokensExpireIn(now()->addMinutes(60));
        Passport::personalAccessTokensExpireIn(now()->addMinutes(60));
        // Rename Auth Tables
        Passport::$clientModel = '\App\Models\Auth\AuthClient';
        Passport::$personalAccessClientModel = '\App\Models\Auth\AuthPersonalAccessClient';
        Passport::$tokenModel        = '\App\Models\Auth\AuthToken';
        Passport::$refreshTokenModel = '\App\Models\Auth\AuthRefreshToken';
        //        Laravel\Passport\Token

    }//end boot()


}//end class

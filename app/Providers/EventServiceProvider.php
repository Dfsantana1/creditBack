<?php
declare(strict_types=1);

namespace App\Providers;

use App\Events\Saml2\SignedOut;
use App\Listeners\Okta\LoginListener;
use App\Listeners\Okta\LogoutListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
    use Slides\Saml2\Events\SignedIn;

/**
 * Class EventServiceProvider
 *
 * @category Providers
 * @package  App\Providers

 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SignedIn::class   => [LoginListener::class],
        SignedOut::class  => [LogoutListener::class],
    ];


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {

    }//end boot()


    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;

    }//end shouldDiscoverEvents()


}//end class

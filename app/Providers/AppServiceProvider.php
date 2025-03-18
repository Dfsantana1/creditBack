<?php
declare(strict_types=1);

namespace App\Providers;

use App\Models\User\PersonalAccessToken;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
/**
 * Class AppServiceProvider
 *
 * @category Providers
 * @package  App\Providers

 */
class AppServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        if (! $this->app->environment('build', 'testing')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

    }//end register()


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        
        Blueprint::macro(
            'dropForeignSafe',
            function ($args) {
                if (!app()->runningUnitTests()) {
                    $this->dropForeign($args);
                }
            }
        );

    }//end boot()


}//end class

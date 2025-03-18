<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

/**
 * Class BroadcastServiceProvider
 *
 * @category Providers
 * @package  App\Providers

 */
class BroadcastServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        include base_path('routes/channels.php');

    }//end boot()


}//end class

<?php
declare(strict_types=1);

namespace App\Console;

use App\Models\Response;
use App\Jobs\ScheduledQueriesJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


/**
 * Class UserProfile
 *
 * @category Kernel
 * @package  App\Console\Commands

 */
class Kernel extends ConsoleKernel
{


    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule // Schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {


    }//end schedule()


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        include base_path('routes/console.php');

    }//end commands()


}//end class

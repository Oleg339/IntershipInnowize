<?php

namespace App\Console;

use App\Additional\Banks\BelarusbankClient;
use App\Jobs\UpdateCurrencies;
use App\Requests\UpdateCurrency;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call( function(){
            //(new UpdateCurrencies())->handle(new BelarusbankClient());
            UpdateCurrencies::dispatch(new BelarusbankClient());
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

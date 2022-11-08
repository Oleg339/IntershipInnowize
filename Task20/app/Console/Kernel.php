<?php

namespace App\Console;

use App\Additional\BankFactory;
use App\Additional\Banks\BelarusbankClient;
use App\Jobs\UpdateCurrencies;
use App\Models\Currency;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $bank = BankFactory::create(BelarusbankClient::class, Currency::all());
            UpdateCurrencies::dispatch($bank);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

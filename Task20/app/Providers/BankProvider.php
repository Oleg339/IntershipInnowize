<?php

namespace App\Providers;

use App\Additional\Bank;
use App\Additional\Banks\BelarusbankClient;
use Illuminate\Support\ServiceProvider;

class BankProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(Bank::class, BelarusbankClient::class);
    }
}

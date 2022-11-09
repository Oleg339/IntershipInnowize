<?php

namespace App\Providers;

use App\Currencies\BelarusbankClient;
use App\Currencies\CurrencyRateSource;
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
//        $this->app->bind(CurrencyRateSource::class, BelarusbankClient::class);
    }
}

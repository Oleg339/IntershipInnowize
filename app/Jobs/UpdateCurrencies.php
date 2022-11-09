<?php

namespace App\Jobs;

use App\Currencies\CurrencyRateSource;
use App\Models\Currency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCurrencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CurrencyRateSource $currencyRateSource;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CurrencyRateSource $currencyRateSource)
    {
        $this->currencyRateSource = $currencyRateSource;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->currencyRateSource->updateCurrencyRates(Currency::all());
    }
}

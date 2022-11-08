<?php

namespace App\Currencies;

use Illuminate\Database\Eloquent\Collection;

interface CurrencyRateSource
{
    public function updateCurrencyRates(Collection $currencies);
}

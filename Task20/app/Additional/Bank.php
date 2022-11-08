<?php

namespace App\Additional;

use Illuminate\Database\Eloquent\Collection;

interface Bank
{
    public function getCurrencyRates(Collection $currencies);
}

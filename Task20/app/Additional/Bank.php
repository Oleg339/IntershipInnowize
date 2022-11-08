<?php

namespace App\Additional;

use Illuminate\Database\Eloquent\Collection;

interface Bank
{
    public function __construct(Collection $currencies);

    public function getCurrencyRates();
}

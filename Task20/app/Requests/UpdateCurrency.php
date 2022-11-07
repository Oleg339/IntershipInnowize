<?php

namespace App\Requests;

use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateCurrency
{
    public static function run($currencies)
    {
        $currencies = BelarusbankClient::getCurrencyRates($currencies);
        foreach ($currencies as $currency => $rate) {
            Currency::where('currency', $currency)->update(['rate' => $rate]);
        }
    }
}

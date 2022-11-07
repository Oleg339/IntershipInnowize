<?php

namespace App\Requests;

use Illuminate\Support\Facades\Http;

class BelarusbankClient
{
    public static function getCurrencyRates($currencies)
    {
        $currencyRates = [];
        $res = Http::acceptJson()->get('https://belarusbank.by/api/kursExchange');
        foreach ($currencies as $currency) {
            $currencyName = $currency;
            $currency = $currency . '_out';
            $rate = json_decode($res->body())[0]->$currency;
            $currencyRates[] = [$currencyName => $rate];
        }

        return $currencyRates;
    }
}

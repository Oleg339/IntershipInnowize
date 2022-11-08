<?php

namespace App\Currencies;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class BelarusbankClient implements CurrencyRateSource
{
    public function updateCurrencyRates(Collection $currencies)
    {
        $res = Http::acceptJson()->get('https://belarusbank.by/api/kursExchange');

        $currencies->each(function ($currency) use ($res) {
            $currencyStr = $currency->currency . '_out';
            $currency->rate = json_decode($res->body())[0]->$currencyStr;
        });

        return $currencies->each->save();
    }
}

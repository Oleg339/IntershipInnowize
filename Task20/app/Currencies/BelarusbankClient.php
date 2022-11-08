<?php

namespace App\Currencies;

use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;

class BelarusbankClient implements CurrencyRateSource
{
    public function updateCurrencyRates(Collection $currencies)
    {
        $client = new Client();
        $res = $client->request('GET', "https://belarusbank.by/api/kursExchange")->getBody()->getContents();

        $currencies->each(function ($currency) use ($res) {
            $currencyStr = $currency->currency . '_out';
            $currency->rate = json_decode($res)[0]->$currencyStr;
        });

        $currencies->each->save();
    }
}

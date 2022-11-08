<?php

namespace App\Additional\Banks;

use Illuminate\Database\Eloquent\Collection;
use App\Additional\Bank;
use Illuminate\Support\Facades\Http;

class BelarusbankClient implements Bank
{
    public function getCurrencyRates(Collection $currencies): Collection
    {
        $res = Http::acceptJson()->get('https://belarusbank.by/api/kursExchange');

        $currencies->each(function ($currency) use ($res) {
            $currencyStr = $currency->currency . '_out';
            $currency->rate = json_decode($res->body())[0]->$currencyStr;
        });

        return $currencies;
    }
}

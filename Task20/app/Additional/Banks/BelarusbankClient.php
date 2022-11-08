<?php

namespace App\Additional\Banks;

use Illuminate\Database\Eloquent\Collection;
use App\Additional\Bank;
use Illuminate\Support\Facades\Http;

class BelarusbankClient implements Bank
{
    private Collection $currencies;

    public function __construct(Collection $currencies)
    {
        $this->currencies = $currencies;
    }

    public function getCurrencyRates(): Collection
    {
        $res = Http::acceptJson()->get('https://belarusbank.by/api/kursExchange');

        $this->currencies->each(function ($currency) use ($res) {
            $currencyStr = $currency->currency . '_out';
            $currency->rate = json_decode($res->body())[0]->$currencyStr;
        });

        return $this->currencies;
    }
}

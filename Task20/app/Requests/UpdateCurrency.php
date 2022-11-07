<?php

namespace App\Requests;

use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UpdateCurrency
{
    public static function run($currencies)
    {
        $res = Http::acceptJson()->get('https://belarusbank.by/api/kursExchange');
        foreach ($currencies as $currency) {
            $currencyName = $currency;
            $currency = $currency . '_out';
            $rate = json_decode($res->body())[0]->$currency;
            Currency::where('currency', $currencyName)->update(['rate' => $rate]);
        }
    }
}

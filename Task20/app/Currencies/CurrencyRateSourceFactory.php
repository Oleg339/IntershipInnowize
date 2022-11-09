<?php

namespace App\Currencies;

class CurrencyRateSourceFactory
{
    public static function create($class)
    {
        return new $class;
    }
}

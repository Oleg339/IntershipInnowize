<?php

namespace App\Additional;

use Illuminate\Database\Eloquent\Collection;

class BankFactory
{
    public static function create($class, Collection $currencies)
    {
        return new $class($currencies);
    }
}

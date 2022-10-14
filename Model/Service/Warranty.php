<?php

namespace Service;

use Model\ServiceAbstract;

class Warranty extends ServiceAbstract
{
    const SERVICE = 'Warranty';

    public function getService()
    {
        return self::SERVICE;
    }
}
<?php

namespace Model\Service;

use Model\ServiceAbstract;

class Delivery extends ServiceAbstract
{
    const SERVICE = 'Delivery';

    public function getService()
    {
        return self::SERVICE;
    }
}
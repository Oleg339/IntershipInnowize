<?php

namespace Model\Service;

use ServiceAbstract;

class Delivery extends ServiceAbstract
{
    const SERVICE = 'Delivery';

    public function getService()
    {
        return self::SERVICE;
    }
}
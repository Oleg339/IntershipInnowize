<?php

namespace Model\Service;

use ServiceAbstract;

class Warranty extends ServiceAbstract
{
    const SERVICE = 'Warranty';

    public function getService()
    {
        return self::SERVICE;
    }
}
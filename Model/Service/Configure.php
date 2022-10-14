<?php

namespace Model\Service;

use Model\ServiceAbstract;

class Configure extends ServiceAbstract
{
    const SERVICE = 'Configure';

    public function getService()
    {
        return self::SERVICE;
    }
}
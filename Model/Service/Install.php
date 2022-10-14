<?php

namespace Model\Service;

use Model\ServiceAbstract;

class Install extends ServiceAbstract
{
    const SERVICE = 'Install';

    public function getService()
    {
        return self::SERVICE;
    }
}
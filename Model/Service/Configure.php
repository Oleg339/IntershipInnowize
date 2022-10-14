<?php

namespace Model\Service;

use Model\ServiceAbstract;
use Model\User;

class Configure extends ServiceAbstract
{
    const SERVICE = 'Configure';

    public function getService()
    {
        return self::SERVICE;
    }

    const TABLE_SQLS = [
        User::class => "CREATE TABLE IF NOT EXISTS Users (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, created VARCHAR(50), email VARCHAR(40) UNIQUE NOT NULL, first_name VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, password VARCHAR(100) NOT NULL)",
        Ban::class => "CREATE TABLE IF NOT EXISTS Ban (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, time VARCHAR(50), ip VARCHAR(50) UNIQUE NOT NULL)"
    ];
}
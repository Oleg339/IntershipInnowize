<?php

use Model\Ban;
use Model\ProductAbstract;
use Model\ServiceAbstract;
use Model\User;

class Config
{
    const TABLE_SQLS = [
        User::class => "CREATE TABLE IF NOT EXISTS Users (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, email VARCHAR(40) UNIQUE NOT NULL, first_name VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, password VARCHAR(100) NOT NULL)",
        ServiceAbstract::class => "CREATE TABLE IF NOT EXISTS Services (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, service VARCHAR(20) NOT NULL, cost VARCHAR(20) NOT NULL, deadline VARCHAR(20))",
        ProductAbstract::class => "CREATE TABLE IF NOT EXISTS Products (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(40), cost VARCHAR(20), manufacture VARCHAR(40), date VARCHAR(30), user_email VARCHAR(30), service INTEGER, FOREIGN KEY (user_email) REFERENCES Users(email), product VARCHAR(30), FOREIGN KEY (service) references Services(id))",
        Ban::class => "CREATE TABLE IF NOT EXISTS Ban (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, time VARCHAR(50), ip VARCHAR(50) UNIQUE NOT NULL)"
    ];
}
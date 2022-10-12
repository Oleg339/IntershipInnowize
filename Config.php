<?php

use Model\User;

class Config
{
    const TABLE_SQLS = [
        User::class => "CREATE TABLE IF NOT EXISTS Users (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, email VARCHAR(40) UNIQUE NOT NULL, first_name VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, password VARCHAR(100) NOT NULL)",
        ServiceAbstract::class => "CREATE TABLE IF NOT EXISTS Services (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, cost VARCHAR(20) NOT NULL, deadline VARCHAR(20))",
        ProductAbstract::class => "CREATE TABLE IF NOT EXISTS Products (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, name VARCHAR(40), cost VARCHAR(20), manufacture VARCHAR(40), date VARCHAR(30), service FOREIGN KEY REFERENCES Services(name), user_id FOREIGN KEY REFERENCES Users(email))"
    ];
}
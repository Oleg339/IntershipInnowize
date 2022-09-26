<?php

class Config
{
    private const USER_DB = 'Users';

    public static function getUserDb(){
        return self::USER_DB;
    }
}
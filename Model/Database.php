<?php

namespace Model;
include_once ('DatabaseConnect.php');
include_once ('Model/User.php');

use Model\User;

use mysqli;

class Database
{
    public static function createTable($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $model::TABLE .
            ' (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, ';

        foreach ($model::FIELDS as $var) {
            $sql .= lcfirst($var) . ' VARCHAR(200), ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $mysqli->query($sql);
    }

    public static function find($model, $findBy, $parameter)
    {
        foreach (self::select($model) as $entityDB) {
            if ($entityDB[$findBy] == $parameter) {
                return $entityDB;
            }
        }

        return [];
    }

    public static function select($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = 'SELECT * FROM ' . $model::TABLE;

        try {
            $result = $mysqli->query($sql);
        } catch (\mysqli_sql_exception $ex) {
            self::createTable($model);
            $result = $mysqli->query($sql);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
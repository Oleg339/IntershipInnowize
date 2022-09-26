<?php

namespace Model;
include_once('DatabaseConnect.php');

use mysqli;

class Database
{
    public static function createTable($model)
    {
        $methods = [];

        foreach (get_class_methods($model) as $method) {
            if (substr($method, 0, 3) == 'get' && $method !== 'getId') {
                $methods[] = $method;
            }
        }

        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $mysqlVars = [];

        foreach ($methods as $method) {
            $mysqlVars[] = substr($method, 3);
        }

        $table = $model::$table;
        $sql = "CREATE TABLE IF NOT EXISTS $table (
        id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, ";

        foreach ($mysqlVars as $var) {
            $sql .= lcfirst($var) . ' VARCHAR(50), ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $mysqli->query($sql);
    }

    public static function store($model)
    {
        $methods = [];

        foreach (get_class_methods($model) as $method) {
            if (substr($method, 0, 3) == 'get' && $method !== 'getId') {
                $methods[] = $method;
            }
        }

        $mysqlValues = [];
        $mysqlVars = [];
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        foreach ($methods as $method) {
            $mysqlVars[] = substr($method, 3);
            $mysqlValues[] = $mysqli->real_escape_string($model->$method());
        }

        $table = $model::$table;
        $sql = "INSERT INTO  $table (";

        foreach ($mysqlVars as $var) {
            $sql .= lcfirst($var) . ', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ') VALUES (';

        foreach ($mysqlValues as $value) {
            $sql .= "'$value', ";
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $mysqli->query($sql);
    }

    public static function find($model, $findBy, $parameter)
    {
        $entitiesDB = self::select($model);
        foreach ($entitiesDB as $entityDB) {
            if ($entityDB[$findBy] == $parameter) {
                return $entityDB;
            }
        }
        return [];
    }

    public static function delete($model)
    {
        $dbName = $model::$table;
        $id = $model->getId();
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = "DELETE FROM $dbName WHERE id = '$id'";
        $mysqli->query($sql);
    }

    public static function update($model): void
    {
        $methods = [];

        foreach (get_class_methods($model) as $method) {
            if (substr($method, 0, 3) == 'get' && $method !== 'getId') {
                $methods[] = $method;
            }
        }

        $mysqlValues = [];
        $mysqlVars = [];
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        foreach ($methods as $method) {
            $mysqlVars[] = substr($method, 3);
            $mysqlValues[] = $mysqli->real_escape_string($model->$method());
        }

        $dbName = $model::$table;
        $sql = "UPDATE $dbName SET ";

        for ($i = 0; $i < sizeof($mysqlVars); $i++) {
            $sql .= "$mysqlVars[$i] = '$mysqlValues[$i]', ";
        }

        $sql = substr($sql, 0, -2);
        $id = $model->getId();

        $sql .= " WHERE id=$id";
        $mysqli->query($sql);
    }

    public static function select($model)
    {
        $table = $model::$table;
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = "SELECT * FROM $table";

        try {
            $result = $mysqli->query($sql);
        } catch (\mysqli_sql_exception $ex) {
            self::createTable($model);
            $result = $mysqli->query($sql);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
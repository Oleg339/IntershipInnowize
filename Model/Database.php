<?php

namespace Model;
include_once('DatabaseConnect.php');

use mysqli;

class Database
{
    public static function createTable($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $model::$fields .
            ' (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, ';

        foreach ($model::$fields as $var) {
            $sql .= lcfirst($var) . ' VARCHAR(50), ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $mysqli->query($sql);
    }

    public static function store($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'INSERT INTO ' . $model::$table . ' ( ';

        foreach ($model::$fields as $var) {
            $sql .= lcfirst($var) . ', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ') VALUES (';

        foreach ($model->getValues() as $value) {
            $sql .= "'$value', ";
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

    public static function delete($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = 'DELETE FROM ' . $model::$table . ' WHERE id = \'' . $model->getId() . '\'';
        $mysqli->query($sql);
    }

    public static function update($model): void
    {
        $mysqlVars = $model::$fields;
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $dbName = $model::$table;
        $sql = 'UPDATE ' . $dbName . ' SET ';
        $vars = [];
        $i = 0;
        foreach ($model->getValues() as $mysqlValue) {
            $sql .= "$mysqlVars[$i] = '$mysqlValue', ";
            $i++;
        }

        $sql = substr($sql, 0, -2);

        $sql .= ' WHERE id=\'' . $model->getId() . '\'';
        $mysqli->query($sql);
    }

    public static function select($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = 'SELECT * FROM ' . $model::$table;

        try {
            $result = $mysqli->query($sql);
        } catch (\mysqli_sql_exception $ex) {
            self::createTable($model);
            $result = $mysqli->query($sql);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
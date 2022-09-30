<?php

namespace Model;
include_once('DatabaseConnect.php');

use mysqli;

class Database
{
    public static function createTable($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $model::TABLE .
            ' (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, ';

        foreach ($model::FIELDS as $var) {
            $sql .= lcfirst($var) . ' VARCHAR(50), ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ')';
        $mysqli->query($sql);
    }

    public static function store($model)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'INSERT INTO ' . $model::TABLE . ' ( ';

        foreach ($model::FIELDS as $var) {
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

        return $mysqli->insert_id;
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

    public static function delete($model): bool
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = 'DELETE FROM ' . $model::TABLE . ' WHERE id = \'' . $model->getId() . '\'';
        return $mysqli->query($sql);
    }

    public static function update($model): void
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        $sql = 'UPDATE ' . $model::TABLE . ' SET ';

        foreach ($model::FIELDS as $field) {
            $sql .= $field . ' = \'' . $model->getValues()[$field] . '\', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ' WHERE id=\'' . $model->getId() . '\'';
        $mysqli->query($sql);
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
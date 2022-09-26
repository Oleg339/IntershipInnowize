<?php

namespace Model;
include_once('DatabaseConnect.php');

use mysqli;

class Database
{
    public static function createTable($class)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $mysqli->query($class::createTableSql());
    }

    public static function store($entity, $dbName)
    {
        $methods = [];

        foreach (get_class_methods($entity) as $method) {
            if (substr($method, 0, 3) == 'get' && $method !== 'getId') {
                $methods[] = $method;
            }
        }

        $mysqlValues = [];
        $mysqlVars = [];
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        foreach ($methods as $method) {
            $mysqlVars[] = substr($method, 3);
            $mysqlValues[] = $mysqli->real_escape_string($entity->$method());
        }

        $sql = "INSERT INTO  $dbName (";
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

    public static function find($dbName, $findBy, $parameter)
    {
        $entitiesDB = self::select($dbName);
        foreach ($entitiesDB as $entityDB) {
            if ($entityDB[$findBy] == $parameter) {
                return $entityDB;
            }
        }
        return [];
    }

    public static function delete($dbName, $deleteBy, $parameter)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = "DELETE FROM $dbName WHERE $deleteBy = '$parameter'";
        $mysqli->query($sql);
    }

    public static function update($entity): void
    {
        $methods = [];

        foreach (get_class_methods($entity) as $method) {
            if (substr($method, 0, 3) == 'get' && $method !== 'getId') {
                $methods[] = $method;
            }
        }

        $mysqlValues = [];
        $mysqlVars = [];
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();

        foreach ($methods as $method) {
            $mysqlVars[] = substr($method, 3);
            $mysqlValues[] = $mysqli->real_escape_string($entity->$method());
        }

        $dbName = $entity::dbNameGet();
        $sql = "UPDATE $dbName SET ";

        for ($i = 0; $i < sizeof($mysqlVars); $i++) {
            $sql .= "$mysqlVars[$i] = '$mysqlValues[$i]', ";
        }
        $sql = substr($sql, 0, -2);
        $id = $entity->getId();

        $sql .= " WHERE id=$id";
        $mysqli->query($sql);
    }

    public static function select($dbName)
    {
        $mysqli = DatabaseConnect::getInstance()->getMysqliConnection();
        $sql = "SELECT * FROM $dbName";
        try {
            $result = $mysqli->query($sql);
        } catch (\mysqli_sql_exception $ex) {
            self::createTable($dbName);
            $result = $mysqli->query($sql);
        }

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}
<?php

namespace Model;

include_once('DatabaseConnect.php');
include_once('Config.php');
include_once('Model/Ban.php');

use Model\Ban;
use PDO;
use Task18\Config;

class Database
{
    public static function createTable($model)
    {
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();

        $pdo->exec(Config::TABLE_SQLS[$model]);
    }

    public static function store($model)
    {
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();

        $sql = 'INSERT INTO ' . $model::TABLE . ' ( ';

        foreach ($model::FIELDS as $var) {
            $sql .= lcfirst($var) . ', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ') VALUES (';

        $values = $model->getValues();

        foreach ($model::FIELDS as $var) {
            $sql .= '\''.$values[$var].'\', ';
        }

        $sql = substr($sql, 0, -2);

        $sql .= ')';

        echo $sql;

        $pdo->query($sql);

        return $pdo->lastInsertId();
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
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();

        $sql = 'SELECT * FROM ' . $model::TABLE;

        try {
            $result = $pdo->query($sql);
        } catch (\PDOException $ex) {
            self::createTable($model);
            $result = $pdo->query($sql);
        }

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function delete($model)
    {
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();
        $sql = 'DELETE FROM ' . $model::TABLE . ' WHERE id = \'' . $model->getId() . '\'';
        $pdo->query($sql);
    }
}
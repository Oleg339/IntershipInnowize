<?php

namespace Model;

require_once 'DatabaseConnect.php';
require_once 'Config.php';
require_once 'Products';
require_once 'Service';
require_once 'Model';

use Config;
use PDO;

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
            if (array_key_exists($var, $values)) {
                $sql .= '\'' . $values[$var] . '\', ';
            }
        }

        $sql = substr($sql, 0, -2);

        $sql .= ')';

        $pdo->query($sql);

        return $pdo->lastInsertId();
    }

    public static function find($model, $findBy, $parameter)
    {
        $data = [];

        foreach (self::select($model) as $entityDB) {
            if ($entityDB[$findBy] == $parameter) {
                $data[] = $entityDB;
            }
        }

        if (sizeof($data) === 1) {
            return $data[0];
        }

        if ($data) {
            return $data;
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
<?php

namespace Model;
include_once('DatabaseConnect.php');

use PDO;

class Database
{
    public static function createTable($model)
    {
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();

        $pdo->beginTransaction();

        $pdo->query($model::CREATE_TABLE_SQL);

        $pdo->commit();
    }

    public static function store($model)
    {
        $pdo = DatabaseConnect::getInstance()->getPdoConnection();

        $pdo->beginTransaction();

        $sql = 'INSERT INTO ' . $model::TABLE . ' ( ';

        foreach ($model::FIELDS as $var) {
            $sql .= lcfirst($var) . ', ';
        }

        $sql = substr($sql, 0, -2);
        $sql .= ', created) VALUES (';

        foreach ($model->getValues() as $value) {
            $sql .= "'$value', ";
        }

        $sql = substr($sql, 0, -4);

        $sql .= 'CURRENT_TIMESTAMP())';

        $pdo->query($sql);

        $pdo->commit();

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

        $pdo->beginTransaction();

        $sql = 'SELECT * FROM ' . $model::TABLE;

        try {
            $result = $pdo->query($sql);
        } catch (\PDOException $ex) {
            self::createTable($model);
            $result = $pdo->query($sql);
        }

        $pdo->commit();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
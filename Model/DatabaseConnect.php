<?php

namespace Model;

use PDO;

class DatabaseConnect
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = 'localhost:3307';
        $db = 'Task19';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_PERSISTENT => true
        ];

        $pdo = new PDO("mysql:host=localhost:3307", 'root', '');
        $result = $pdo->query("show databases like 'db_name'");
        if ($result->fetchAll(PDO::FETCH_ASSOC) == []) {
            self::create();

            return $this->pdo = new PDO($dsn, $user, $pass, $opt);
        }

        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseConnect();
        }

        return self::$instance;
    }

    public function getPdoConnection()
    {
        return $this->pdo;
    }

    public static function create()
    {
        $pdo = new PDO("mysql:host=localhost:3307", 'root', '');

        $pdo->query("CREATE DATABASE IF NOT EXISTS Task19");
    }
}
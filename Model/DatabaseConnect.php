<?php

namespace Model;
use mysqli;
use PDO;

class DatabaseConnect
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $host = 'localhost:3307';
        $db   = 'Task17';
        $user = 'root';
        $pass = 'root';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $opt);

        $result = $this->pdo->query("show databases like '$db'");

        if(!$result->fetchAll(PDO::FETCH_ASSOC)){
            self::create();

            $this->pdo = new PDO($dsn, $user, $pass, $opt);
        }
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
        $pdo = new PDO("mysql:host=localhost:3307", 'root', 'root');

        $pdo->query("CREATE DATABASE IF NOT EXISTS Task17");
    }
}
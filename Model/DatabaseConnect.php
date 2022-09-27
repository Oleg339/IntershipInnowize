<?php

namespace Model;

use mysqli;

class DatabaseConnect
{
    private static $instance = null;
    private $mysqli;

    private function __construct()
    {
        try {
            $this->mysqli = new mysqli("localhost", "root", "root", "Task13");
        } catch (\mysqli_sql_exception $ex) {
            self::create();
            $this->mysqli = new mysqli("localhost", "root", "root", "Task13");
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DatabaseConnect();
        }

        return self::$instance;
    }

    public function getMysqliConnection()
    {
        return $this->mysqli;
    }

    public static function create()
    {
        $mysqli = new  mysqli("localhost", "root", "root");
        $sql = "CREATE DATABASE IF NOT EXISTS Task13";
        $mysqli->query($sql);
    }
}
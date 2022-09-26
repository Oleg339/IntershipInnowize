<?php

namespace Model;

class User
{
    private $email;
    private $name;
    private $gender;
    private $status;
    private $id;
    private static $dbName = 'Users';

    public function __construct(array $values)
    {
        //var_dump($values);
        //echo '<br>'.$values['email'];
        $this->email = $values['email'];
        $this->name = $values['name'];
        $this->gender = $values['gender'];
        $this->status = $values['status'];
        if(array_key_exists('id', $values)){
            $this->id = $values['id'];
        }
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }


    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public static function dbNameGet(): string
    {
        return self::$dbName;
    }

    public static function createTableSql()
    {
        return "CREATE TABLE IF NOT EXISTS Users (
            id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(50),
            name VARCHAR(50),
            gender VARCHAR(20),
            status VARCHAR(10))";
    }
}
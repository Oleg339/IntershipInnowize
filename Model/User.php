<?php

namespace Model;

include_once('Database.php');

use Model\Database;

class User
{
    const TABLE = 'Users';
    const CREATE_TABLE_SQL = "CREATE TABLE IF NOT EXISTS Users (id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT, created TIMESTAMP, email VARCHAR(40) UNIQUE NOT NULL, first_name VARCHAR(20) NOT NULL, last_name VARCHAR(20) NOT NULL, password VARCHAR(100) NOT NULL)";
    const FIELDS = ['email', 'first_name', 'last_name', 'password'];

    protected $password;

    protected $email;

    protected $firstName;

    protected $lastName;

    protected $id;

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->password = password_hash($data['password'], PASSWORD_DEFAULT);

        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
        }
    }

    public function getValues()
    {
        return [
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'password' => $this->password,
            'id' => $this->id
        ];
    }

    public function save()
    {
        $this->id = Database::store($this);
        return $this;
    }

    public static function all()
    {
        return Database::select(self::class);
    }

    public static function find($findBy, $parameter)
    {
        $user = Database::find(self::class, $findBy, $parameter);

        if (!$user) {
            return false;
        }

        return new User($user);
    }
}
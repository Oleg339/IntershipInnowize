<?php

namespace Model;

include_once('ModelDB.php');

class User implements ModelDB
{
    const TABLE = 'Users';

    const FIELDS = ['email', 'first_name', 'last_name', 'password'];

    protected $firstName;

    protected $lastName;

    protected $password;

    protected $email;

    protected $id;

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];

        return $this;
    }

    public function getTable()
    {
        return self::TABLE;
    }

    public function getId()
    {
        return $this->id;
    }

    public function save()
    {
        $this->id = Database::store($this);

        return $this;
    }

    public function getValues(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'id' => $this->id
        ];
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
<?php

namespace Model;

include_once('Database.php');

use Model\Database;

class User
{
    const TABLE = 'Users';
    const FIELDS = ['email', 'first_name', 'last_name', 'password', 'created'];

    protected $password;

    protected $email;

    protected $firstName;

    protected $lastName;

    protected $id;

    protected $created;

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->firstName = $data['first_name'];
        $this->lastName = $data['last_name'];
        $this->password = $data['password'];

        if (array_key_exists('id', $data)) {
            $this->created = $data['created'];
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
            'created' => $this->created ?: date('d-m-y h:i:s'),
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
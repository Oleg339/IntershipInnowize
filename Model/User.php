<?php

namespace Model;

class User
{
    protected $password;

    protected $email;

    protected $name;

    protected $id;

    const TABLE = 'Users';
    const FIELDS = ['email', 'name', 'password'];

    public function __construct($data)
    {
        $this->email = $data['email'];
        $this->password = $data['password'];

        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
            $this->name = $data['name'];
        }
    }

    public function getValues()
    {
        return [
            'email' => $this->email,
            'password' => $this->password
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

    public function getName()
    {
        return $this->name;
    }
}
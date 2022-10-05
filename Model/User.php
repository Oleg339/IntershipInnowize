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
        $this->name = $data['name'];

        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
        }
    }

    public function getValues()
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
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

    public static function all()
    {
        return Database::select(self::class);
    }
}
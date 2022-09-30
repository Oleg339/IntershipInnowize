<?php

namespace Model;

include_once('Database.php');

class User
{
    protected $email;
    protected $name;
    protected $gender;
    protected $status;
    protected $id;

    const TABLE = 'Users';
    const FIELDS = ['email', 'name', 'gender', 'status'];

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->name = $data['name'];
        $this->gender = $data['gender'];
        $this->status = $data['status'];

        if (array_key_exists('id', $data)) {
            $this->id = $data['id'];
        }
    }

    public function getValues()
    {
        return array_merge([
            'email' => $this->email,
            'name' => $this->name,
            'gender' => $this->gender,
            'status' => $this->status
        ], $this->id ? ['id' => $this->id] : []
        );
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

    public function save()
    {
        $this->id = Database::store($this);
        return $this;
    }

    public function update()
    {
        return Database::update($this);
    }

    public function delete()
    {
        if (self::find($this->id)) {
            Database::delete($this);
        }

        return false;
    }

    public static function all(): array
    {
        return Database::select(self::class);
    }

    public static function find($id)
    {
        $user = Database::find(User::class, 'id', $id);
        if ($user) {
            return new User($user);
        }
        return false;
    }
}
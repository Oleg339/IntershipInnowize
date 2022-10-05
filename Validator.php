<?php

include_once('Model/Database.php');
include_once('Model/User.php');

use Model\Database;
use Model\User;


class Validator
{
    private $values;

    private $errors = [];

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validate($data): bool
    {
        foreach ($data as $key => $values) {
            foreach ($values as $value) {
                $value = explode(':', $value);
                $method = $value[0];

                if (sizeof($value) === 1) {
                    $this->$method($key);
                } else {
                    $this->$method($key, $value[1]);
                }
            }
        }

        if (sizeof($this->errors)) {
            return false;
        }

        return true;
    }

    private function addError($error)
    {
        $this->errors = array_merge($this->errors, $error);
    }

    private function email($value)
    {
        $email = $this->values[$value];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError(['email' => "Email $email is invalid"]);

            return true;
        }

        if (!Database::find(User::class, 'email', $email)) {
            $this->addError(['email' => "User with email $email does not exists"]);

            return true;
        }

        return false;
    }

    private function emailCorresponding($value)
    {
        $password = $this->values[$value];
        $email = $this->values['email'];

        foreach (Database::select(User::class) as $user){
            if($user['email'] === $email && password_verify($password, $user['password'])){
                return false;
            }
        }

        $this->addError(['password' => 'Wrong password']);

        return true;
    }
}
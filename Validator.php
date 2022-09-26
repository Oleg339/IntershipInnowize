<?php

use Model\Database;
use Model\User;

class Validator
{
    private $values = [];
    private $validated = [];
    private $errors = [];

    public function __construct($valuesToValidate)
    {
        $this->values = $valuesToValidate;
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
            $this->validated = array_merge($this->validated, [$key => $this->values[$key]]);
        }

        if (sizeof($this->errors)) {
            return false;
        }

        return true;
    }

    private function length($value, $min_max)
    {
        $min_max = explode(',', $min_max);

        $min = $min_max[0];
        $max = $min_max[1];

        if (strlen($this->values[$value]) < $min) {
            $this->errors = $this->values[$value] . 'size less than' . $min;
        }

        if (strlen($this->values[$value]) > $max) {
            $this->errors = $this->values[$value] . 'size greater than' . $max;
        }
    }

    private function email($value)
    {
        $email = $this->values[$value];
        $findUser = Database::find(User::class, 'email', $email);
        if (array_key_exists('id', $this->values)) {
            if ($findUser && $findUser['id'] != $this->values['id']) {
                $this->errors[] = "User with $email email already exist";
            }
        } elseif ($findUser) {
            $this->errors[] = "User with $email email already exist";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email $email is invalid";
        }
    }

    private function required($value)
    {
        if (array_key_exists($value, $this->values)) {
            return;
        }

        $this->errors[] = "$value is required";
    }

    private function string($name)
    {
        if (is_string($name)) {
            return;
        }

        $this->errors[] = "$name is not string";
    }

    public function getValidated(): array
    {
        if (array_key_exists('id', $this->values)) {
            $this->validated = array_merge($this->validated, ['id' => $this->values['id']]);
        }

        return $this->validated;
    }
}
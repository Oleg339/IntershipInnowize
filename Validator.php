<?php

use Model\Database;
use Model\User;

class Validator
{
    private $values = [];
    private $validated = [];
    private $errors = [];

    public function __construct($data)
    {
        $this->values = $data;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validate($data): bool
    {
        foreach ($data as $key => $values) {
            $hasErrors = false;

            foreach ($values as $value) {
                $value = explode(':', $value);
                $method = $value[0];

                if (sizeof($value) === 1) {
                    $hasErrors = $this->$method($key);
                } else {
                    $hasErrors = $this->$method($key, $value[1]);
                }
            }

            if ($hasErrors) {
                continue;
            }

            $this->validated = array_merge($this->validated, [$key => $this->values[$key]]);
        }

        if (sizeof($this->errors)) {
            return false;
        }

        if (array_key_exists('id', $this->values)) {
            $this->validated = array_merge($this->validated, ['id' => $this->values['id']]);
        }

        return true;
    }

    private function length($value, $data)
    {
        $data = explode(',', $data);

        $min = $data[0];
        $max = $data[1];

        if (strlen($this->values[$value]) < $min) {
            $this->errors = $this->values[$value] . 'size less than' . $min;
            return true;
        }

        if (strlen($this->values[$value]) > $max) {
            $this->errors = $this->values[$value] . 'size greater than' . $max;
            return true;
        }
        return false;
    }

    private function email($value)
    {
        $email = $this->values[$value];
        $findUser = Database::find(User::class, 'email', $email);
        if (array_key_exists('id', $this->values)) {
            if ($findUser && $findUser['id'] != $this->values['id']) {
                $this->errors[] = "User with $email email already exist";
                return true;
            }
        } elseif ($findUser) {
            $this->errors[] = "User with $email email already exist";
            return true;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email $email is invalid";
            return true;
        }
        return false;
    }

    private function required($value): bool
    {
        if (array_key_exists($value, $this->values)) {
            if (isset($this->values[$value])) {
                return false;
            }
        }
        $this->errors[] = "$value is required";
        return true;
    }

    private function string($name)
    {
        if (is_string($name)) {
            return false;
        }

        $this->errors[] = "$name is not string";
        return true;
    }

    public function getValidated(): array
    {
        return $this->validated;
    }
}
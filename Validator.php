<?php

use Model\Database;
use Model\User;

class Validator
{
    private $values = [];
    private $validated = [];
    private $errors = [];

    public function __construct($values)
    {
        $this->values = $values;
    }

    private function addError($error)
    {
        $this->errors = array_merge($this->errors, $error);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function validate($data): bool
    {
        foreach ($data as $key => $values) {
            $hasErrors = false;

            if ($this->required($key)) {
                continue;
            }

            foreach ($values as $value) {
                $value = explode(':', $value);
                $method = $value[0];

                if (sizeof($value) === 1) {
                    $hasErrors = $this->$method($key);
                } else {
                    $hasErrors = $this->$method($key, $value[1]);
                }
            }

            if (!$hasErrors) {
                $this->validated = array_merge($this->validated, [$key => $this->values[$key]]);
            }
        }

        if (sizeof($this->errors)) {
            return false;
        }

        return true;
    }

    private function length($value, $data)
    {
        $data = explode(',', $data);

        $min = $data[0];
        $max = $data[1];

        if (strlen($this->values[$value]) < $min) {
            $this->addError(['length' => $this->values[$value] . ' size less than ' . $min]);
            return true;
        }

        if (strlen($this->values[$value]) > $max) {
            $this->addError(['length' => $this->values[$value] . 'size greater than ' . $max]);
            return true;
        }
        return false;
    }

    private function email($value)
    {
        $email = $this->values[$value];
        $findUser = Database::find(User::class, 'email', $email);

        $isExistsId = array_key_exists('id', $this->values);
        if ($isExistsId && $findUser && $this->values['id'] != $findUser['id']) {
            $this->addError(['email' => "User with $email email already exist"]);
            return true;
        } elseif ($findUser && !$isExistsId) {
            $this->addError(['email' => "User with $email email already exist"]);
            return true;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError(['email' => "Email $email is invalid"]);
            return true;
        }
        return false;
    }

    private function required($value): bool
    {
        if (array_key_exists($value, $this->values) &&
            isset($this->values[$value]) &&
            !empty($this->values[$value])
        ) {
            return false;
        }

        $this->addError(['required' => "$value is required"]);
        return true;
    }

    private function string($value)
    {
        if (is_string($value)) {
            return false;
        }

        $this->addError(['string' => "$value is not string"]);
        return true;
    }

    public function getValidated(): array
    {
        return $this->validated;
    }
}
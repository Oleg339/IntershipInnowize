<?php

namespace Task18;

use Model\Database;
use Model\User;

class FieldsValidator
{
    private $values;

    private $validated = [];

    private $errors = [];

    private $file;

    private $directory;

    const EXTENSIONS = ['png', 'img', 'txt', 'jpg'];

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

            if($this->isUploaded($key)){
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

    private function password($value)
    {
        $password = $this->values[$value];

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if ($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 6) {
            return false;
        }

        $this->addError(['password' => 'Password should be at least 6 characters in length and should include at least one upper case letter, one number, and one special character']);

        return true;
    }

    private function email($value)
    {
        $email = $this->values[$value];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError(['email' => "Email $email is invalid"]);

            return true;
        }

        return false;
    }

    private function isUploaded($value)
    {
        if ($this->values[$value]['name'] !== '') {
            return false;
        }

        $this->errors[] = 'File not exists';

        return true;
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

    private function isExists($value)
    {
        if (file_exists($this->values['directory'] . '/' . $this->values[$value]['name'])) {
            $this->errors[] = 'File already exists';

            return true;
        }

        return false;
    }

    private function size($value) //TODO: Проверять в контроллере
    {
        if ($this->values[$value]['size'] > disk_free_space("C:")) {
            $this->errors[] = 'Size too big';

            return true;
        }

        return false;
    }

    private function extention($value)
    {
        if (!in_array(end(explode('.', $this->values[$value]['name'])), self::EXTENSIONS)) {
            $this->errors[] = 'Invalid extention';

            return true;
        }

        return false;
    }

    public function getValidated(): array
    {
        return $this->validated;
    }
}
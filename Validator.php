<?php

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

    private function password($value)
    {
        $password = $this->values[$value];

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if($uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8) {
            return false;
        }

        $this->addError(['password' => 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character']);

        return true;
    }
}
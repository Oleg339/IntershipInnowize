<?php

use Model\Database;
use Model\User;

class Validator
{
    private $valuesToValidate;

    private $validatedValues = [];

    private $errorMessages = [];

    public function __construct($valuesToValidate)
    {
        $this->valuesToValidate = $valuesToValidate;
    }

    public function getErrorMessages(){
        return $this->errorMessages;
    }

    public function validate($validationParameters)
    {
        foreach ($validationParameters as $key => $values) {
            foreach ($values as $value){
                $value = explode(':', $value);
                $method = $value[0];
                if (sizeof($value) === 1) {
                    $errorMessage = $this->$method($key);
                } else {
                    $errorMessage = $this->$method($key, $value[1]);
                }
            }
            if($errorMessage){
                $this->errorMessages = array_merge($this->errorMessages, $errorMessage);
                continue;
            }
            $this->validatedValues = array_merge($this->validatedValues, [$key => $this->valuesToValidate[$key]]);
        }

        if (sizeof($this->errorMessages)) {
            return false;
        }

        return true;
    }

    private function length($value, $min_max): array
    {
        $min_max = explode(',', $min_max);
        $errorMessages = [];
        if(strlen($this->valuesToValidate[$value]) < $min_max[0]){
            $errorMessages[] = $this->valuesToValidate[$value].'size less than'.$min_max[0];
        }
        if(strlen($this->valuesToValidate[$value]) > $min_max[1]){
            $errorMessages[] = $this->valuesToValidate[$value].'size greater than'.$min_max[1];
        }
        return $errorMessages;
    }

    private function email($value): array
    {
        $errorMessages = [];
        $email = $this->valuesToValidate[$value];
        $findUser = Database::find(Config::getUserDb(), 'email', $email);
        if(array_key_exists('id', $this->valuesToValidate)){
            if ($findUser && $findUser['id'] != $this->valuesToValidate['id']) {
                $errorMessages[] = "User with $email email already exist";
            }
        } elseif ($findUser) {
            $errorMessages[] = "User with $email email already exist";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = "Email $email is invalid";
        }
        return $errorMessages;
    }

    private function required($value){
        $errorMessages = [];
        if(array_key_exists($value, $this->valuesToValidate)){
            return [];
        }

        $errorMessages[] = "$value is required";

        return $errorMessages;
    }

    private function string($name): array
    {
        $errorMessages = [];
        foreach (explode(' ', $name) as $str){
            if (!preg_match("/^[a-zA-z]*$/", $str)) {
                $errorMessages[] = "Invalid name $name";
            }
        }

        return $errorMessages;
    }

    private function gender($value){
        if ($this->valuesToValidate[$value] !== 'Male' && $this->valuesToValidate[$value] !== 'Female'){
            return ["$value is not a gender"];
        }
        return [];
    }

    private function status($value){
        if ($this->valuesToValidate[$value] !== 'Active' && $this->valuesToValidate[$value] !== 'Inactive'){
            return ["$value is not a status"];
        }
        return [];
    }

    public function getValidated(){
        if(array_key_exists('id', $this->valuesToValidate)){
            $this->validatedValues = array_merge($this->validatedValues, ['id' => $this->valuesToValidate['id']]);
        }
        return $this->validatedValues;
    }
}
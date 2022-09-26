<?php

namespace Model;

class DatabaseSeeder extends Database
{
    public static function seedUsersInDB($countOfUsers)
    {
        for ($i = 0; $i < $countOfUsers; $i++) {
            $email = self::generateRandomString() . '@gmail.com';
            $name = self::generateRandomString();
            $value = rand(0, 1) == 1;
            $gender = $value == 1 ? 'Male' : 'Female';
            $value = rand(0, 1) == 1;
            $status = $value == 1 ? 'Active' : 'Inactive';
            $user = new User(['email' => $email, 'name'=>$name, 'value'=>$value, 'gender'=>$gender]);
            self::store($user, \Config::getUserDb());
        }
    }

    private static function generateRandomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
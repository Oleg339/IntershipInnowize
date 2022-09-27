<?php

namespace Model;

class UserSeeder extends Database
{
    public static function run($count = 10)
    {
        for ($i = 0; $i < $count; $i++) {
            $email = self::generateRandomString() . '@gmail.com';
            $name = self::generateRandomString();
            $value = rand(0, 1) == 1;
            $gender = $value == 1 ? 'Male' : 'Female';
            $value = rand(0, 1) == 1;
            $status = $value == 1 ? 'Active' : 'Inactive';
            $user = new User(['email' => $email, 'name'=>$name, 'status'=>$status, 'gender'=>$gender]);
            self::store($user);
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
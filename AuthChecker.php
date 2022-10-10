<?php

namespace Task18;

include_once('Model/User.php');
include_once('TwigLoader.php');

use Model\User;

class AuthChecker
{
    public static function check($request)
    {
        $twig = TwigLoader::run();

        $request = $request->getCookie();

        if (!array_key_exists('email', $request)) {
            header("Location: http://localhost:8001/login");
        }

        $user = User::find('email', $request['email']);

        if (!$user || !hash_equals($user->getValues()['password'], $request['password'])) {
            header("Location: http://localhost:8001/login");
        }

        return $user;
    }
}
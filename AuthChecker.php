<?php

namespace Task18;

include_once('TwigLoader.php');

class AuthChecker
{
    public static function getUserEmail($session)
    {
        if (!array_key_exists('email', $session)) {
            echo TwigLoader::run()->render('Login.html');
            exit();
        }

        return $session['email'];
    }
}
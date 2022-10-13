<?php

namespace Task18;

include_once('TwigLoader.php');

class AuthChecker
{
    public static function getUserEmail($session)
    {
        if (!isset($session['email'])) {
            echo TwigLoader::run()->render('Login.html');
            exit();
        }

        return $session['email'];
    }
}
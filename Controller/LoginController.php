<?php

namespace Controller;

include_once('Logger.php');
include_once('Model/User.php');
include_once('TwigLoader.php');
include_once('Model/Ban.php');

use Model\Ban;
use Model\User;
use Task18\Logger;
use Task18\TwigLoader;

class LoginController
{
    public function index($request, $errors = [])
    {
        $ip = $request->getServer()['REMOTE_ADDR'];

        if (Ban::get($ip)) {
            $this->banned();
        }

        setcookie("email", "", time() - 3600);
        setcookie("password", "", time() - 3600);

        $twig = TwigLoader::run();

        echo $twig->render('Login.html', ['errors' => $errors]);
    }

    public function login($request)
    {

        if (!isset($_SESSION['CountOfAttempts']))
        {
            $_SESSION['CountOfAttempts'] = 0;
        }

        $ip = $request->getServer()['REMOTE_ADDR'];

        if (Ban::get($ip)) {
            $this->banned();
        }

        if ($request->getSession()['CountOfAttempts'] >= 3) {
            $_SESSION['CountOfAttempts'] = 0;

            $ban = new Ban(['ip' => $ip, 'email' => $request->getPost()['email']]);

            $request->getPost()['email'];

            $ban->save();

            $this->banned();
        }

        $request = $request->getPost();

        $user = User::find('email', $request['email']);

        if (!$user || !password_verify($request['password'], $user->getValues()['password'])) {
            $_SESSION['CountOfAttempts']++;
            return $this->index(new \Task18\Request(), ['Login incorrect']);
        }

        $_SESSION['CountOfAttempts'] = 0;

        echo $user->getValues()['password'];

        if ($request['remember']) {
            setcookie('email', $user->getValues()['email'], time() + 3600 * 24 * 7);
            setcookie('password', $user->getValues()['password'], time() + 3600 * 24 * 7);
        } else {
            setcookie('email', $user->getValues()['email'], time() + 3600);
            setcookie('password', $user->getValues()['password'], time() + 3600);
        }

        header("Location: http://localhost:8001/files");
    }

    public function banned()
    {
        $twig = TwigLoader::run();

        echo $twig->render('Banned.html');

        exit();
    }
}
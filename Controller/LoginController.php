<?php

namespace Controller;

include_once('Model/User.php');
include_once('TwigLoader.php');
include_once('Model/Ban.php');

use Model\Ban;
use Model\User;
use Task18\TwigLoader;

class LoginController
{
    public function index($request, $errors = [])
    {
        if (!array_key_exists('CountOfAttempts', $_SESSION) || $_SESSION['CountOfAttempts'] === 0) {
            session_destroy();
        }

        $ip = $request->getServer()['REMOTE_ADDR'];

        if (Ban::get($ip)) {
            $this->banned();
        }

        echo TwigLoader::run()->render('Login.html', ['errors' => $errors]);
    }

    public function login($request)
    {
        if (!isset($_SESSION['CountOfAttempts'])) {
            $_SESSION['CountOfAttempts'] = 0;
        }

        $ip = $request->getServer()['REMOTE_ADDR'];

        if (Ban::get($ip)) {
            $this->banned();
        }

        if ($_SESSION['CountOfAttempts'] >= 3) {
            $_SESSION['CountOfAttempts'] = 0;

            $ban = new Ban(['ip' => $ip, 'email' => $request->getPost()['email']]);

            $request->getPost()['email'];

            $ban->save();

            $this->banned();
        }

        $values = $request->getPost();

        $user = User::find('email', $values['email']);

        if (!$user || !password_verify($values['password'], $user->getValues()['password'])) {
            $_SESSION['CountOfAttempts']++;

            return $this->index($request, ['Login incorrect']);
        }

        $_SESSION['CountOfAttempts'] = 0;

        $_SESSION['email'] = $user->getValues()['email'];

        if ($values['remember']) {
            setcookie(session_id());
        }

        header("Location: http://localhost:8001/files");
    }

    public function banned()
    {
        echo TwigLoader::run()->render('Banned.html');

        exit();
    }
}
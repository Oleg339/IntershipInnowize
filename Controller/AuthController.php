<?php

namespace Controller;

include_once('Validator.php');
include_once('Model/User.php');

use Validator;
use Model\User;

class AuthController
{
    public function index($request, $error = '')
    {
        require_once 'bootstrap.php';

        echo $twig->render(
            'Authentication.html',
            ['error' => $error]
        );
    }

    public function authenticate($request)
    {
        $request = $request->get();

        $user = new User($request);

        $validator = new Validator($user->getValues());

        $isValidated = $validator->validate([
            'email' => ['email'],
            'password' => ['emailCorresponding']
        ]);

        if (!$isValidated) {
            return $this->index($request,'Login is incorrect');
        }

        require_once 'bootstrap.php';

        echo $twig->render(
            'Congrats.html',
            ['name' => $user::find('email', $request['email'])->getName()]
        );
    }
}
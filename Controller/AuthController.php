<?php

namespace Controller;

include_once('Validator.php');
include_once('Model/User.php');

use Validator;
use Model\User;

class AuthController
{
    public function index($request, $errors = [])
    {
        require_once 'bootstrap.php';

        echo $twig->render('Login.html', ['errors' => $errors]);
    }

    public function login($request)
    {
        $request = $request->get();

        $validator = new Validator($request);

        $isValidated = $validator->validate([
            'email' => ['email'],
            'password' => ['password']
        ]);

        $isAuth = false;

        foreach (User::all() as $user){
            if($user['email'] === $request['email'] && password_verify($request['password'], $user['password'])){
                $isAuth = true;
            }
        }

        if (!$isValidated || !$isAuth) {
            return $this->index($request,$validator->getErrors());
        }

        $user = User::find('email', $request['email']);

        require_once 'bootstrap.php';

        echo $twig->render(
            'Congrats.html',
            ['user' => $user->getValues()]
        );
    }
}
<?php

namespace Controller;

include_once('Model/User.php');
include_once('FieldsValidator.php');
include_once('TwigLoader.php');

use Model\User;
use Task18\TwigLoader;
use Task18\FieldsValidator;

class RegistrationController
{
    public function index($request, $errors = [], $validated = [])
    {
        setcookie("email", "", time() - 3600);
        setcookie("password", "", time() - 3600);

        $twig = TwigLoader::run();

        echo $twig->render('Registration.html', ['errors' => $errors, 'validated' => $validated]);
    }

    public function registration($request)
    {
        $request = $request->get();

        $validator = new FieldsValidator($request);

        $isValidated = $validator->validate([
            'email' => ['email'],
            'confirm_email' => ['email'],
            'first_name' => ['string', 'length:3,12'],
            'last_name' => ['string', 'length:3,12'],
            'password' => ['password'],
            'confirm_password' => ['password']
        ]);

        $validated = $validator->getValidated();

        if (!$isValidated) {
            return $this->index($request, $validator->getErrors(), $validated);
        }

        $errors = [];

        if ($validated['email'] != $validated['confirm_email']) {
            $errors[] = 'Input correspond email to "confirm email" field';
        }

        if ($validated['password'] != $validated['confirm_password']) {
            $errors[] = 'Input correspond password to "confirm password" field';
        }

        if (User::find('email', $validated['email'])) {
            $errors[] = 'User with this email already exists';
        }

        if ($errors) {
            return $this->index($request, $errors, $validated);
        }

        $validated['password'] = password_hash($validated['password'], PASSWORD_DEFAULT);

        $user = new User($validated);

        $user->save();

        try {
            $a = 0;
        } catch (\PDOException) {
            $this->index($request, ['Error with store user in database']);
        }

        if ($request['remember']) {
            setcookie('email', $user->getValues()['email'], time() + 3600 * 24 * 7);
            setcookie('password', $user->getValues()['password'], time() + 3600 * 24 * 7);
        }

        header("Location: http://localhost:8001/files");
    }
}
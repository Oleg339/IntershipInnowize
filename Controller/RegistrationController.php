<?php

namespace Controller;

include_once('Model/User.php');
include_once('Validator.php');

use Model\User;
use Validator;

class RegistrationController
{
    public function index($request, $errors = [], $validated = [])
    {
        require_once('bootstrap.php');

        echo $twig->render('Registration.html', ['errors' => $errors, 'validated' => $validated]);
    }

    public function registration($request)
    {
        $request = $request->get();

        $validator = new Validator($request);

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

        $user = new User($validated);

        try {
            $user->save();
        } catch (\PDOException) {
            $this->index($request, ['Error with store user in database']);
        }

        require_once('bootstrap.php');

        echo $twig->render('Congrats.html', ['user' => $user->getValues()]);
    }
}
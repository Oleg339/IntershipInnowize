<?php

namespace Controller;

include_once('Model/User.php');
include_once('Validator.php');
include_once('TwigLoader.php');

use Model\User;
use Task18\TwigLoader;
use Task18\Validator;

class RegistrationController
{
    public function index($request, $errors = [], $validated = [])
    {
        session_destroy();

        echo TwigLoader::run()->render('Registration.html', ['errors' => $errors, 'validated' => $validated]);
    }

    public function registration($request)
    {
        $request = $request->get();

        $validator = new Validator($request);

        $isValidated = $validator->validate([
            'email' => ['email', 'required'],
            'confirm_email' => ['email', 'required'],
            'first_name' => ['string', 'length:3,12', 'required'],
            'last_name' => ['string', 'length:3,12', 'required'],
            'password' => ['password', 'required'],
            'confirm_password' => ['password', 'required']
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

        $_SESSION['email'] = $user->getValues()['email'];

        if ($request['remember']) {
            setcookie(session_id(), time() + 3600 * 24 * 7);
        }

        header("Location: http://localhost:8001/files");
    }
}
<?php

namespace Controller;

use Model\Database;
use Model\User;

include_once('Validator.php');
include_once('Model/User.php');
include_once('Model/Database.php');
include_once('Config.php');

class UserController
{
    public function index($errors = []): void
    {
        $usersDB = Database::select(User::class);
        $users = [];

        foreach ($usersDB as $userDB) {
            $users[] = new User($userDB);
        }

        include 'View/ListOfUsers.php';
    }

    public function update($Request): void
    {
        $validator = new \Validator($Request->get());
        $validated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($validated) {
            $user = new User($validator->getValidated());
            Database::update($user);
        }

        $this->index($validator->getErrors());
    }

    public function edit($Request): void
    {
        $userDB = Database::find(User::class, 'email', $Request->getGET()['Email']);
        $user = new User($userDB);
        Database::update($user);
        include 'View/EditUser.php';
    }

    public function delete($Request): void
    {
        $user = new User(Database::find(User::class, 'email', $Request->getGET()['Email']));
        Database::delete($user);
        $this->index();
    }

    public static function create()
    {
        include 'View/AddUser.php';
    }

    public function store($Request): void
    {
        $validator = new \Validator($Request->getPOST());
        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            Database::store(new User($validator->getValidated()));
        }

        $this->index($validator->getErrors());
    }
}

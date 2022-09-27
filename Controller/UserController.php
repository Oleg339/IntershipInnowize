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
        $users = [];

        foreach (Database::select(User::class) as $userDB) {
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
            Database::update(new User($validator->getValidated()));
        }

        $this->index($validator->getErrors());
    }

    public function edit($Request): void
    {
        $user = new User(Database::find(User::class, 'email', $Request->getGET()['Email']));
        Database::update($user);
        include 'View/EditUser.php';
    }

    public function delete($Request): void
    {
        Database::delete(new User(Database::find(User::class, 'email', $Request->getGET()['Email'])));
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

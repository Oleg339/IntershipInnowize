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
    public function index($errorMessages = []): void
    {
        $usersDB = Database::select(\Config::getUserDb());
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
            'gender' => ['required', 'gender'],
            'status' => ['required', 'status'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($validated) {
            $user = new User($validator->getValidated());
            Database::update($user);
        }

        $this->index($validator->getErrorMessages());
    }

    public function edit($Request): void
    {
        $userDB = Database::find(\Config::getUserDb(), 'email', $Request->getGET()['Email']);
        $user = new User($userDB);
        Database::update($user);
        include 'View/EditUser.php';
    }

    public function delete($Request): void
    {
        Database::delete(\Config::getUserDb(), 'email', $Request->getGET()['Email']);
        $this->index();
    }

    public static function create()
    {
        include 'View/AddUser.php';
    }

    public function store($Request): void
    {
        $validator = new \Validator($Request->getPOST());
        $validated = $validator->validate([
            'gender' => ['required', 'gender'],
            'status' => ['required', 'status'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($validated) {
            $user = new User($validator->getValidated());
            Database::store($user, \Config::getUserDb());
        }

        $this->index($validator->getErrorMessages());
    }
}

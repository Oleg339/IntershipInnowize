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

    public function update($request): void
    {
        $REQUEST = $request->get();

        $userId = $REQUEST['id'];
        if(!Database::find(User::class, 'id', $userId)){
            $this->index('There are no User with ' . $userId . 'id');
        }

        $validator = new \Validator($REQUEST);
        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            Database::update(new User(array_merge($validator->getValidated(), ['id' => $userId])));
        }

        $this->index($validator->getErrors());
    }

    public function edit($request): void
    {
        $user = new User(Database::find(User::class, 'email', $request->getGET()['Email']));

        include 'View/EditUser.php';
    }

    public function delete($request): void
    {
        Database::delete(new User(Database::find(User::class, 'email', $request->getGET()['Email'])));

        $this->index();
    }

    public static function create()
    {
        include 'View/AddUser.php';
    }

    public function store($request): void
    {
        $validator = new \Validator($request->getPOST());
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

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
    public function index($errors = []): array
    {
        $users = [];

        foreach (Database::select(User::class) as $userDB) {
            $users[] = new User($userDB);
        }
        return $users;
        //include 'View/ListOfUsers.php';
    }

    public function update($request): void
    {
        $REQUEST = $request->get();

        $userId = $REQUEST['id'];
        if (!Database::find(User::class, 'id', $userId)) {
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

    public function edit($request, $id): void
    {
        $user = new User(Database::find(User::class, 'id', $id));
        include 'View/EditUser.php';
    }

    public function delete($id)
    {
        $user = Database::find(User::class, 'id', $id);

        if(!$user){
            return false;
        }

        return Database::delete(new User($user));
    }

    public static function create()
    {
        include 'View/AddUser.php';
    }

    public function store($request)
    {
        $validator = new \Validator($request->getPOST());
        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User($validator->getValidated());
            $user->setId(Database::store($user));
            return $user;
        }

        return $validator->getErrors();
    }
}

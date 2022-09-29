<?php

namespace Controller\Api;

include_once('Validator.php');
include_once('Model/User.php');
include_once('Model/Database.php');

use Model\Database;
use Model\User;

class UserApi
{
    public function index()
    {
        $users = [];

        foreach (Database::select(User::class) as $userDB) {
            $users[] = new User($userDB);
        }

        $data = $this->convertToArray($users);

        header('X-Pagination-Total: ' . sizeof($data));

        echo json_encode($data);
    }

    public function store($request)
    {
        $validator = new \Validator($request->getPost());

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User($validator->getValidated());
            $user->setId(Database::store($user));

            http_response_code(201);

            echo json_encode($user->getValues());

            return;
        }

        http_response_code(400);

        echo json_encode(['messages' => $validator->getErrors()]);
    }

    public function delete($request, $data)
    {
        $id = $data[0];

        $user = Database::find(User::class, 'id', $id);

        if (!$user) {
            http_response_code(404);

            echo json_encode(['messages' => 'Resource not found']);

            return;
        }

        Database::delete(new User($user));

        http_response_code(204);
    }

    public function show($request, $data)
    {
        $id = $data[0];

        $user = Database::find(User::class, 'id', $id);

        if ($user) {
            http_response_code(200);

            echo json_encode($user);

            return;
        }

        http_response_code(404);

        echo json_encode(['message' => 'resource not found']);
    }

    public function update($request, $data): void
    {
        $id = $data[0];
        $request = $request->get();

        if (!Database::find(User::class, 'id', $id)) {
            http_response_code(404);

            echo json_encode(['message' => 'Resource not found']);

            return;
        }

        $validator = new \Validator(array_merge($request, ['id' => $id]));

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User(array_merge($validator->getValidated(), ['id' => $id]));
            Database::update($user);

            http_response_code(200);

            echo json_encode($user->getValues());

            return;
        }

        http_response_code(400);

        echo json_encode($validator->getErrors());
    }

    private function convertToArray($users)
    {
        $data = [];

        foreach ($users as $user) {
            $data[] = $user->getValues();
        }

        return $data;
    }
}

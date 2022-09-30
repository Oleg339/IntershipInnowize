<?php

namespace Controller\Api;

include_once('Validator.php');
include_once('Model/User.php');

use Model\User;

class UserController
{
    public function index()
    {
        $data = json_encode(User::all());

        include 'View/ListOfUsers.php';
    }

    public function create()
    {
        $errors = '';
        include 'View/AddUser.php';
    }

    public function edit($request, $value)
    {
        $data = $this->show($request, $value);

        include 'View/EditUser.php';
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
            $user->save();

            http_response_code(201);

            $this->index();
            return;
        }

        http_response_code(400);

        $errors = json_encode(['messages' => $validator->getErrors()]);
        include 'View/AddUser.php';
    }

    public function delete($request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            http_response_code(404);

            echo json_encode(['messages' => ['Resource not found']]);

            return;
        }

        $user->delete();

        http_response_code(204);

        $this->index();
    }

    public function show($request, $id)
    {
        $user = User::find($id);

        if ($user) {
            http_response_code(200);

            return json_encode($user->getValues());
        }

        http_response_code(404);

        echo json_encode(['messages' => ['Resource not found']]);
    }

    public function update($request, $id): void
    {
        $request = $request->get();

        if (!User::find($id)) {
            http_response_code(401);

            echo json_encode(['messages' => ['Resource not found']]);

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

            http_response_code(200);

            echo json_encode($user->update()->getValues());

            return;
        }

        http_response_code(402);

        echo json_encode(['messages' => $validator->getErrors()]);
    }
}

<?php

namespace Controller\Api;

include_once('Validator.php');
include_once('Model/User.php');
include_once('Response.php');

use Model\User;
use Response;
use Validator;

class UserController
{
    public function index()
    {
        Response::json(200, User::all());
    }

    public function store($request)
    {
        $validator = new Validator($request->get());

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User($validator->getValidated());
            $user->save();

            Response::json(201, $user->getValues());

            return;
        }

        Response::json(400, ['messages' => $validator->getErrors()]);
    }

    public function delete($request, $id)
    {
        $user = User::find($id);

        if(!$user){
            Response::notFound();

            return;
        }

        $user->delete();

        Response::json(204);
    }

    public function show($request, $id)
    {
        $user = User::find($id);

        if ($user) {
            Response::json(200, $user->getValues());

            return;
        }

        Response::notFound();
    }

    public function update($request, $id): void
    {
        $request = $request->get();

        if (!User::find($id)) {
            Response::notFound();

            return;
        }

        $validator = new Validator(array_merge($request, ['id' => $id]));

        $isValidated = $validator->validate([
            'gender' => ['required'],
            'status' => ['required'],
            'email' => ['required', 'email'],
            'name' => ['required', 'length:4,20', 'string']
        ]);

        if ($isValidated) {
            $user = new User(array_merge($validator->getValidated(), ['id' => $id]));
            $user->update();
            Response::json(200, $user->getValues());

            return;
        }

        Response::json(400, ['messages' => $validator->getErrors()]);
    }
}
